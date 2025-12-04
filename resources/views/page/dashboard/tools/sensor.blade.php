@extends('layout.dashboard')
@section('title', 'Tools - Sensor - Tomat Guard')
@section('page', 'toolsSensor')
@section('breadcrumb', 'Tools')
@section('pageName', 'Tools Sensor')

@section('x-data', 'sensorModal: false, groupModal: false')


@section('content')
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] mb-10">
        <div class="px-5 py-4 sm:px-6 sm:py-5 flex items-center justify-between">
            <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                My Sensors
            </h3>
            <div class="relative">
                <button @click="sensorModal = true"
                    class="inline-flex items-center gap-2 rounded bg-brand-500 px-3 py-2 text-sm text-white hover:bg-brand-600">
                    + Tambah Sensor
                </button>

            </div>
        </div>
        <div class="border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">
            <!-- ====== Table Six Start -->
            <div
                class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="max-w-full overflow-x-auto">
                    <table class="min-w-full">
                        <!-- table header start -->
                        <thead>
                            <tr class="border-b border-gray-100 dark:border-gray-800">
                                <th class="px-5 py-3 sm:px-6 text-left">
                                    <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">No</p>
                                </th>
                                <th class="px-5 py-3 sm:px-6 text-left">
                                    <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Sensor</p>
                                </th>

                                <th class="px-5 py-3 sm:px-6 text-left">
                                    <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Type</p>
                                </th>

                                <th class="px-5 py-3 sm:px-6 text-center">
                                    <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Actions</p>
                                </th>
                            </tr>
                        </thead>
                        <!-- table header end -->
                        <!-- table body start -->
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            @forelse($sensors as $sensor)
                                <tr>
                                    <td class="px-5 py-4 sm:px-6">
                                        <div class="flex items-center">
                                            <p class="text-theme-sm text-gray-500 dark:text-gray-400">{{ $loop->iteration }}
                                            </p>
                                        </div>
                                    </td>

                                    <td class="px-5 py-4 sm:px-6">
                                        <div class="flex items-center">
                                            <p class="text-theme-sm text-gray-800 dark:text-white/90">{{ $sensor->name }}
                                            </p>
                                        </div>
                                    </td>

                                    <td class="px-5 py-4 sm:px-6">
                                        <div class="flex items-center">
                                            <p class="text-theme-sm text-gray-500 dark:text-gray-400">
                                                {{ $sensor->type ?? '-' }}</p>
                                        </div>
                                    </td>


                                    <td class="px-5 py-4 sm:px-6">
                                        <div class="flex items-center justify-center">
                                            <a href="{{ route('dashboard.tools.sensor.show', $sensor->id) }}"
                                                class="text-theme-sm text-blue-600 hover:underline dark:text-blue-400">Detail</a>
                                            <span class="mx-2 text-gray-300 dark:text-gray-600">|</span>
                                            <form action="{{ route('dashboard.tools.sensor.destroy', $sensor->id) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-theme-sm text-red-600 hover:underline dark:text-red-400">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-5 py-6 text-center text-sm text-gray-500">
                                        You don't own any sensors yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] mb-10">
        <div class="px-5 py-4 sm:px-6 sm:py-5 flex items-center justify-between">
            <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                Sensors Group
            </h3>
            <div class="relative">
                <button @click="groupModal = true"
                    class="inline-flex items-center gap-2 rounded bg-brand-500 px-3 py-2 text-sm text-white hover:bg-brand-600">
                    + Tambah Group
                </button>
            </div>
        </div>
        <div class="border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">
            <!-- ====== Table Six Start -->
            <div
                class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="max-w-full overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="border-b border-gray-100 dark:border-gray-800">
                                <th class="px-5 py-3 sm:px-6 text-left">
                                    <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">No</p>
                                </th>
                                <th class="px-5 py-3 sm:px-6 text-left">
                                    <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Group Name</p>
                                </th>
                                <th class="px-5 py-3 sm:px-6 text-left">
                                    <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Description</p>
                                </th>
                                <th class="px-5 py-3 sm:px-6 text-center">
                                    <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Actions</p>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            @forelse($groups as $group)
                                <tr>
                                    <td class="px-5 py-4 sm:px-6">
                                        <p class="text-theme-sm text-gray-500 dark:text-gray-400">{{ $loop->iteration }}</p>
                                    </td>
                                    <td class="px-5 py-4 sm:px-6">
                                        <p class="text-theme-sm text-gray-800 dark:text-white/90">
                                            {{ $group->name ?? 'Unnamed' }}</p>
                                    </td>
                                    <td class="px-5 py-4 sm:px-6">
                                        <p class="text-theme-sm text-gray-500 dark:text-gray-400">
                                            {{ Str::limit($group->description ?? '-', 60) }}</p>
                                    </td>
                                    <td class="px-5 py-4 sm:px-6 text-center">
                                        <div x-data="{ open: false }" class="inline-block">
                                            <button @click="open = true"
                                                class="text-theme-sm text-blue-600 hover:underline dark:text-blue-400">Edit</button>

                                            <!-- Group Edit Modal (per-group) -->
                                            <div x-show="open" x-cloak
                                                class="fixed inset-0 z-99999 flex items-center justify-center p-5">
                                                <div class="fixed inset-0 bg-black/50" @click="open = false"></div>
                                                <div @click.outside="open = false"
                                                    class="relative w-full max-w-lg rounded-2xl bg-white p-6 dark:bg-gray-900">
                                                    <h3 class="mb-3 text-lg font-semibold text-gray-800 dark:text-white">
                                                        Edit Group: {{ $group->name }}</h3>
                                                    <form
                                                        action="{{ route('dashboard.tools.sensor.group.update', $group->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')

                                                        <div class="mb-4">
                                                            <label
                                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Group
                                                                Name</label>
                                                            <input type="text" name="name"
                                                                value="{{ $group->name }}"
                                                                class="mt-1 w-full rounded border px-3 py-2 text-sm" />
                                                        </div>

                                                        <div class="mb-4">
                                                            <label
                                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                                                            <textarea name="description" class="mt-1 w-full rounded border px-3 py-2 text-sm">{{ $group->description }}</textarea>
                                                        </div>

                                                        <div class="mb-4">
                                                            <label
                                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Add
                                                                Sensors</label>
                                                            <div class="mt-2 max-h-40 overflow-y-auto border rounded p-2">
                                                                @forelse($sensors as $sensorOption)
                                                                    <label class="flex items-center gap-2 text-sm py-1">
                                                                        <input type="checkbox" name="sensors[]"
                                                                            value="{{ $sensorOption->id }}"
                                                                            {{ $group->sensors->contains($sensorOption->id) ? 'checked' : '' }} />
                                                                        <span>{{ $sensorOption->name ?? '#' . $sensorOption->id }}</span>
                                                                    </label>
                                                                @empty
                                                                    <div class="text-sm text-gray-500">No sensors
                                                                        available.</div>
                                                                @endforelse
                                                            </div>
                                                        </div>

                                                        <div class="flex justify-end gap-2">
                                                            <button type="button" @click="open = false"
                                                                class="rounded border px-3 py-2 text-sm">Cancel</button>
                                                            <button type="submit"
                                                                class="rounded bg-brand-500 px-3 py-2 text-sm text-white">Save</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-5 py-6 text-center text-sm text-gray-500">No sensor
                                        groups
                                        found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- ====== Table Six End -->
        </div>
    </div>

    <!-- Create Group Modal -->
    <div x-show="groupModal" x-cloak class="fixed inset-0 z-99999 flex items-center justify-center p-5">
        <div class="fixed inset-0 bg-black/50" @click="groupModal = false"></div>
        <div @click.outside="groupModal = false"
            class="relative w-full max-w-lg rounded-2xl bg-white p-6 dark:bg-gray-900">
            <h3 class="mb-3 text-lg font-semibold text-gray-800 dark:text-white">Buat Group Baru</h3>
            <form action="{{ route('dashboard.tools.sensor.group.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Group Name</label>
                    <input type="text" name="name" required class="mt-1 w-full rounded border px-3 py-2 text-sm" />
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                    <textarea name="description" class="mt-1 w-full rounded border px-3 py-2 text-sm"></textarea>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" @click="groupModal = false"
                        class="rounded border px-3 py-2 text-sm">Cancel</button>
                    <button type="submit" class="rounded bg-brand-500 px-3 py-2 text-sm text-white">Create</button>
                </div>
            </form>
        </div>
    </div>

@endsection


@section('modals')

    <!-- Modal -->
    <div x-show="sensorModal" x-cloak class="fixed inset-0 z-99999 flex items-center justify-center overflow-y-auto p-5">
        <div class="modal-close-btn fixed inset-0 h-full w-full bg-gray-400/50 backdrop-blur-[32px]"
            @click="sensorModal = false"></div>
        <div @click.outside="sensorModal = false"
            class="no-scrollbar relative w-full max-w-[700px] overflow-y-auto rounded-3xl bg-white p-4 lg:p-11 dark:bg-gray-900">
            <!-- close btn -->
            <button @click="sensorModal = false"
                class="transition-color absolute top-5 right-5 z-999 flex h-11 w-11 items-center justify-center rounded-full bg-gray-100 text-gray-400 hover:bg-gray-200 hover:text-gray-600 dark:bg-gray-700 dark:bg-white/[0.05] dark:text-gray-400 dark:hover:bg-white/[0.07] dark:hover:text-gray-300">
                <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M6.04289 16.5418C5.65237 16.9323 5.65237 17.5655 6.04289 17.956C6.43342 18.3465 7.06658 18.3465 7.45711 17.956L11.9987 13.4144L16.5408 17.9565C16.9313 18.347 17.5645 18.347 17.955 17.9565C18.3455 17.566 18.3455 16.9328 17.955 16.5423L13.4129 12.0002L17.955 7.45808C18.3455 7.06756 18.3455 6.43439 17.955 6.04387C17.5645 5.65335 16.9313 5.65335 16.5408 6.04387L11.9987 10.586L7.45711 6.04439C7.06658 5.65386 6.43342 5.65386 6.04289 6.04439C5.65237 6.43491 5.65237 7.06808 6.04289 7.4586L10.5845 12.0002L6.04289 16.5418Z"
                        fill="" />
                </svg>
            </button>
            <div class="px-2 pr-14">
                <h4 class="mb-2 text-2xl font-semibold text-gray-800 dark:text-white/90">
                    Tambah Sensor
                </h4>
                <p class="mb-6 text-sm text-gray-500 lg:mb-7 dark:text-gray-400">
                    Masukkan ID sensor untuk mendaftarkan keterkaitan ke akun Anda.
                </p>
            </div>
            <form class="flex flex-col" action="{{ route('dashboard.tools.sensor.store') }}" method="POST">
                @csrf
                <div class="custom-scrollbar overflow-y-auto px-2">
                    <div class="mt-7">
                        <div class="grid grid-cols-1 gap-x-6 gap-y-5">
                            <div class="col-span-1">
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Sensor
                                    ID</label>
                                <input type="text" name="sensor_id" required
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                    placeholder="e.g. 12345" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex items-center gap-3 px-2 lg:justify-end">
                    <button @click="sensorModal = false" type="button"
                        class="flex w-full justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 sm:w-auto dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03]">
                        Close
                    </button>
                    <button type="submit"
                        class="bg-brand-500 hover:bg-brand-600 flex w-full justify-center rounded-lg px-4 py-2.5 text-sm font-medium text-white sm:w-auto">
                        Tambah Sensor
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
