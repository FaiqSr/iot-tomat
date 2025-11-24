import {
    getDatabase,
    ref,
    query,
    orderByChild,
    startAt,
    limitToLast,
    get,
    onChildAdded,
    off,
} from "firebase/database";
import ApexCharts from "apexcharts";
import { app } from "./config";

const db = getDatabase(app);

// --- STATE ---
let chart = null;
let seriesData = [];
let activeListeners = {}; // { path: { callback, ref } }
let currentTimeRangeMs = 60 * 60 * 1000; // Default 1 jam

// --- CONFIGURATION ---
const MAX_CHART_POINTS = 500; // Batasi titik di grafik agar enteng

function isDarkMode() {
    return document.documentElement.classList.contains("dark");
}

// Opsi Chart
function getChartOptions() {
    const dark = isDarkMode();
    return {
        chart: {
            type: "area",
            height: 360,
            animations: { enabled: false }, // MATIKAN animasi untuk performa
            toolbar: { show: true },
            background: "transparent",
            foreColor: dark ? "#9ca3af" : "#374151",
            fontFamily: "inherit",
        },
        theme: {
            mode: dark ? "dark" : "light",
            palette: "palette1",
        },
        dataLabels: { enabled: false },
        series: [{ name: "value", data: [] }],
        xaxis: {
            type: "datetime",
            tooltip: { enabled: false },
            axisBorder: { color: dark ? "#374151" : "#e5e7eb" },
            axisTicks: { color: dark ? "#374151" : "#e5e7eb" },
            labels: { style: { colors: dark ? "#9ca3af" : "#6b7280" } },
        },
        yaxis: {
            labels: {
                formatter: (val) => val.toFixed(1),
                style: { colors: dark ? "#9ca3af" : "#6b7280" },
            },
        },
        grid: {
            borderColor: dark ? "#374151" : "#e5e7eb",
        },
        stroke: { curve: "smooth", width: 2 },
        fill: {
            type: "gradient",
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.7,
                opacityTo: 0.1,
                stops: [0, 90, 100],
            },
        },
        markers: { size: 0 },
        tooltip: {
            x: { format: "dd MMM HH:mm" },
            theme: dark ? "dark" : "light",
        },
    };
}

function createChart(container = "#chartAnalytic") {
    if (chart) chart.destroy();
    const options = getChartOptions();
    chart = new ApexCharts(document.querySelector(container), options);
    chart.render();
}

function updateChartTheme() {
    if (!chart) return;
    chart.updateOptions(getChartOptions());
}

// --- CORE: DATA PROCESSING ---

// 1. Downsampling: Mengurangi jumlah titik data
function downsample(data, threshold) {
    if (data.length <= threshold) return data;

    const sampled = [];
    sampled.push(data[0]); // First

    const step = (data.length - 2) / (threshold - 2);
    for (let i = 1; i < threshold - 1; i++) {
        const index = Math.floor(i * step);
        if (data[index]) sampled.push(data[index]);
    }

    sampled.push(data[data.length - 1]); // Last
    return sampled;
}

function renderSeries(fullData) {
    if (!chart) return;

    // 1. Sort berdasarkan waktu
    fullData.sort((a, b) => a.t - b.t);

    // 2. Filter berdasarkan Time Range (Client Side Filtering)
    // Ini menjamin data lama terbuang meskipun kita fetch pakai limitToLast
    const cutoff = Date.now() - currentTimeRangeMs;
    const filteredData = fullData.filter((p) => p.t >= cutoff);

    console.log(
        "[DEBUG] renderSeries: total=",
        fullData.length,
        "filtered=",
        filteredData.length
    );

    // 3. Potong data agar grafik enteng
    const visualData = downsample(filteredData, MAX_CHART_POINTS);

    chart.updateSeries(
        [{ name: "Value", data: visualData.map((p) => [p.t, p.v]) }],
        true
    );
}

function normalizePoint(key, payload, metric) {
    // Priority 1: Field 'timestamp' di dalam data
    // Priority 2: Key data itu sendiri (jika key adalah angka timestamp)
    let ts = payload && payload.timestamp ? payload.timestamp : Number(key);

    // Normalize to Number and handle common units (seconds vs milliseconds)
    ts = Number(ts);
    if (!ts || isNaN(ts)) ts = null;
    else {
        // If timestamp looks like seconds (10 digits), convert to ms for JS Date
        // 1e12 ~ year 33658 in ms; typical ms timestamps are >= 1e12
        if (ts < 1e12) ts = ts * 1000;
    }

    // Auto-detect key cases (suhu_udara vs Suhu_Udara vs temp)
    let val = null;
    if (payload) {
        if (payload[metric] !== undefined) val = payload[metric];
        else {
            // Case insensitive search
            const lowerMetric = metric.toLowerCase();
            const keyFound = Object.keys(payload).find((k) =>
                k.toLowerCase().includes(lowerMetric)
            );
            if (keyFound) val = payload[keyFound];
        }
    }

    // Jika timestamp invalid, jangan kembalikan point
    if (ts === null) {
        console.debug(
            "[DEBUG] normalizePoint: invalid timestamp for key",
            key,
            "payload",
            payload
        );
        return { t: 0, v: null };
    }

    return { t: ts, v: val !== null ? Number(val) : null };
}

// --- LOGIC UTAMA: FETCH & LISTEN ---

async function subscribeSensor(sensorId, metric = "suhu_udara") {
    if (!sensorId) return;

    // 1. Bersihkan listener lama
    unsubscribeAll();

    // Reset Chart visual
    if (chart) chart.updateSeries([{ data: [] }]);

    const path = `data/sensor/${sensorId}`;
    const sensorRef = ref(db, path);

    console.log(`[DEBUG] Starting Subscribe: ${path} | Metric: ${metric}`);

    // --- STRATEGI BARU: FETCH PAKSA 500 DATA TERAKHIR ---
    // Kita tidak pakai startAt() di sini untuk menghindari masalah jam/timezone/index.
    // Kita ambil mentah 500 terakhir, lalu filter di JS.
    const historyQuery = query(sensorRef, limitToLast(500));

    try {
        const snapshot = await get(historyQuery);

        if (!snapshot.exists()) {
            console.warn("[DEBUG] Snapshot kosong / path salah.");
        } else {
            console.log(`[DEBUG] Data ditemukan: ${snapshot.size} records.`);
        }

        const tempSeries = [];
        snapshot.forEach((child) => {
            const p = normalizePoint(child.key, child.val(), metric);
            // Debug sampel data pertama
            if (tempSeries.length === 0)
                console.log("[DEBUG] Sample Point:", p, "Raw:", child.val());

            if (p.v !== null && !isNaN(p.v) && p.t > 0) {
                tempSeries.push(p);
            }
        });

        // Simpan ke variable global seriesData
        seriesData = tempSeries;
        renderSeries(seriesData);
    } catch (e) {
        console.error("[DEBUG] Error fetching history:", e);
        // Fallback: Jika error index, coba force load tanpa query (bahaya jika data besar, tapi ok untuk debug)
    }

    // 3. LISTEN REALTIME (Untuk data yang MASUK SETELAH INI)
    // startAt(Date.now()) memastikan kita tidak memuat ulang data lama
    // Kita perlu orderByChild('timestamp') di sini, pastikan rules firebase sudah benar.
    // Jika masih error index, listener ini mungkin gagal, tapi history di atas tetap muncul.
    let realtimeQuery;
    try {
        realtimeQuery = query(
            sensorRef,
            orderByChild("timestamp"),
            startAt(Date.now())
        );
    } catch (e) {
        // Fallback jika orderByChild gagal, listen ujung node saja
        console.log("[DEBUG] Fallback to simple limit listener");
        realtimeQuery = query(sensorRef, limitToLast(1));
    }

    const onNewData = (child) => {
        const p = normalizePoint(child.key, child.val(), metric);

        // Validasi agar data realtime tidak duplikat drastis atau null
        if (p.v !== null && !isNaN(p.v)) {
            // Cek apakah data ini benar-benar baru (lebih besar dari data terakhir di grafik)
            const lastPoint = seriesData[seriesData.length - 1];
            if (!lastPoint || p.t > lastPoint.t) {
                seriesData.push(p);

                // Update chart
                requestAnimationFrame(() => renderSeries(seriesData));
            }
        }
    };

    const unsub = onChildAdded(realtimeQuery, onNewData);

    activeListeners[path] = {
        callback: onNewData,
        query: realtimeQuery,
        type: "sensor",
    };
}

// Group Logic
async function subscribeGroup(sensorIds = [], metric = "suhu_udara") {
    if (!Array.isArray(sensorIds) || sensorIds.length === 0) return;
    unsubscribeAll();
    if (chart) chart.updateSeries([{ data: [] }]);

    // Untuk Group, kita fetch 100 terakhir dari tiap sensor
    const promises = sensorIds.map((id) => {
        const q = query(ref(db, `data/sensor/${id}`), limitToLast(100));
        return get(q).then((snap) => {
            const arr = [];
            snap.forEach((child) => {
                const p = normalizePoint(child.key, child.val(), metric);
                if (p.v !== null && !isNaN(p.v)) arr.push(p);
            });
            return arr;
        });
    });

    const results = await Promise.all(promises);
    // Flatten array: [[p1, p2], [p3, p4]] -> [p1, p2, p3, p4]
    const allPoints = results.flat();

    if (allPoints.length === 0) {
        console.log("[DEBUG] Group data kosong");
        return;
    }

    // Grouping by minute
    const bucket = {};
    allPoints.forEach((p) => {
        const timeKey = Math.floor(p.t / 60000) * 60000;
        bucket[timeKey] = bucket[timeKey] || [];
        bucket[timeKey].push(p.v);
    });

    // Hitung rata-rata
    const averagedData = Object.keys(bucket).map((k) => ({
        t: Number(k),
        v: bucket[k].reduce((a, b) => a + b, 0) / bucket[k].length,
    }));

    seriesData = averagedData;
    renderSeries(seriesData);
}

function unsubscribeAll() {
    Object.keys(activeListeners).forEach((path) => {
        const listener = activeListeners[path];
        if (listener && listener.query && listener.callback) {
            off(listener.query, "child_added", listener.callback);
        }
    });
    activeListeners = {};
    seriesData = [];
}

// --- UI INITIALIZATION ---

function initUI() {
    createChart("#chartAnalytic");

    const observer = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
            if (mutation.attributeName === "class") {
                updateChartTheme();
            }
        });
    });
    observer.observe(document.documentElement, { attributes: true });

    const metricSelect = document.getElementById("metricSelect");
    const rangeSelect = document.getElementById("timeRangeSelect");
    const sensorRadios = document.getElementsByName("sensorSelect");
    const groupRadios = document.getElementsByName("groupSelect");

    // Prediction Elements
    const btnPredict = document.getElementById("btnPredict");
    const btnUseSensor = document.getElementById("btnUseSensor");
    const predictValue = document.getElementById("predictValue");
    const inputs = {
        Suhu_Udara: document.getElementById("feat_suhu"),
        Kelembaban_Udara: document.getElementById("feat_kel"),
        Kelembaban_Tanah: document.getElementById("feat_soil"),
        pH_Tanah: document.getElementById("feat_ph"),
        Intensitas_Cahaya: document.getElementById("feat_ldr"),
    };

    function getSelectedSensor() {
        for (const r of sensorRadios) if (r.checked) return r.value;
        return null;
    }
    function getSelectedGroup() {
        for (const r of groupRadios) if (r.checked) return r.value;
        return null;
    }

    function onSelectionChange() {
        const metric = metricSelect.value;
        const groupId = getSelectedGroup();
        const sensorId = getSelectedSensor();

        // Update Time Range Value
        const rangeVal = rangeSelect ? rangeSelect.value : "1h";
        switch (rangeVal) {
            case "1h":
                currentTimeRangeMs = 1 * 60 * 60 * 1000;
                break;
            case "7h":
                currentTimeRangeMs = 7 * 60 * 60 * 1000;
                break;
            case "24h":
                currentTimeRangeMs = 24 * 60 * 60 * 1000;
                break;
            case "7d":
                currentTimeRangeMs = 7 * 24 * 60 * 60 * 1000;
                break;
            case "30d":
                currentTimeRangeMs = 30 * 24 * 60 * 60 * 1000;
                break;
            default:
                currentTimeRangeMs = 60 * 60 * 1000;
        }

        console.log(
            `[DEBUG] Selection Changed. Sensor: ${sensorId}, Metric: ${metric}, Range: ${rangeVal}`
        );

        if (groupId) {
            const g = (window.INITIAL_GROUPS || []).find(
                (x) => String(x.id) === String(groupId)
            );
            const ids = g ? Array.from(g.sensors) : [];
            subscribeGroup(ids, metric);
        } else if (sensorId) {
            subscribeSensor(sensorId, metric);
        } else {
            if (chart) chart.updateSeries([{ data: [] }]);
        }
    }

    // Listeners
    if (metricSelect)
        metricSelect.addEventListener("change", onSelectionChange);
    if (rangeSelect) rangeSelect.addEventListener("change", onSelectionChange);
    sensorRadios.forEach((r) =>
        r.addEventListener("change", onSelectionChange)
    );
    groupRadios.forEach((r) => r.addEventListener("change", onSelectionChange));

    // Predict Button Logic
    if (btnPredict) {
        btnPredict.addEventListener("click", () => {
            const features = {};
            Object.keys(inputs).forEach(
                (k) => (features[k] = parseFloat(inputs[k].value) || 0)
            );
            doPredict(features, predictValue);
        });
    }

    // Use Sensor Button Logic
    if (btnUseSensor) {
        btnUseSensor.addEventListener("click", async () => {
            const sensorId = getSelectedSensor();
            if (!sensorId) return alert("Pilih sensor terlebih dahulu");

            try {
                // Fetch only last 1 data for input form
                const q = query(
                    ref(db, `data/sensor/${sensorId}`),
                    limitToLast(1)
                );
                const snap = await get(q);
                let val = null;
                snap.forEach((c) => (val = c.val()));

                if (val) {
                    const mapKey = (k) => {
                        const low = k.toLowerCase();
                        const keys = Object.keys(val);
                        const match = keys.find((xk) =>
                            xk.toLowerCase().includes(low)
                        );
                        return match ? val[match] : 0;
                    };

                    inputs.Suhu_Udara.value = mapKey("suhu") || mapKey("temp");
                    inputs.Kelembaban_Udara.value =
                        mapKey("kel_udara") || mapKey("hum");
                    inputs.Kelembaban_Tanah.value =
                        mapKey("soil") || mapKey("tanah");
                    inputs.pH_Tanah.value = mapKey("ph");
                    inputs.Intensitas_Cahaya.value =
                        mapKey("ldr") || mapKey("light");

                    btnPredict.click();
                } else {
                    alert("Data sensor kosong.");
                }
            } catch (e) {
                console.error(e);
            }
        });
    }

    // Initial Load
    const firstSensor =
        window.INITIAL_SENSORS && window.INITIAL_SENSORS[0]
            ? window.INITIAL_SENSORS[0].id
            : null;
    if (firstSensor) {
        const radio = document.querySelector(
            `input[name='sensorSelect'][value='${firstSensor}']`
        );
        if (radio) {
            radio.checked = true;
            onSelectionChange();
        }
    }
}

// Prediction API Call
async function doPredict(features, resultEl) {
    resultEl.textContent = "...";
    try {
        // include the selected sensor id when available so saved predictions reference the sensor
        const sensorRadio = document.querySelector(
            "input[name='sensorSelect']:checked"
        );
        const sensorId = sensorRadio ? sensorRadio.value : null;

        const body = sensorId
            ? { features, sensor_id: sensorId }
            : { features };

        const res = await fetch("/api/predict", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(body),
        });
        const json = await res.json();
        if (res.ok && json.prediction) {
            resultEl.textContent = Number(json.prediction).toFixed(2);
            if (json.id)
                appendPredictionCard(json.id, json.prediction, features);
        } else {
            resultEl.textContent = "Err";
        }
    } catch (e) {
        resultEl.textContent = "Err";
    }
}

function appendPredictionCard(id, pred, feat) {
    const box = document.getElementById("predictionCards");
    if (!box) return;
    const div = document.createElement("div");
    div.className =
        "p-3 mb-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded shadow-sm flex justify-between items-center";
    div.innerHTML = `
        <div>
            <div class="text-xs font-bold text-gray-500">#${id}</div>
            <div class="text-lg font-bold text-blue-600 dark:text-blue-400">${Number(
                pred
            ).toFixed(2)} cm</div>
        </div>
        <a href="/predictions/${id}/download" class="text-xs px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded hover:bg-gray-200">Download</a>
    `;
    box.prepend(div);
}

// Start
if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initUI);
} else {
    initUI();
}

export default { initUI };
