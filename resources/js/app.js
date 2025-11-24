import "./bootstrap";
import.meta.glob(["../images/**"]);

// Firebase analytics realtime charting (client-side)
import "./firebase/analytics-firebase";

const darkMode = localStorage.getItem("darkMode");
if (darkMode === "true") {
    document.documentElement.classList.add("dark");
} else {
    document.documentElement.classList.remove("dark");
}
