@extends('layout.dashboard')
@section('title', 'Tools - Sensor - Tomat Guard')
@section('page', 'toolsSensor')

@section('content')
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] mb-10">
        <div class="px-5 py-4 sm:px-6 sm:py-5 flex items-center justify-between">
            <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                My Sensors
            </h3>
            <div>
                <a href="#"
                    class="inline-flex items-center gap-2 rounded bg-brand-500 px-3 py-2 text-sm text-white hover:bg-brand-600">+
                    Tambah Sensor</a>
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

                                <th class="px-5 py-3 sm:px-6 text-left">
                                    <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Description</p>
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
                                        <div class="flex items-center">
                                            <p class="text-theme-sm text-gray-500 dark:text-gray-400">
                                                {{ Str::limit($sensor->description ?? '-', 40) }}</p>
                                        </div>
                                    </td>

                                    <td class="px-5 py-4 sm:px-6">
                                        <div class="flex items-center justify-center">
                                            <a href="#"
                                                class="text-theme-sm text-blue-600 hover:underline dark:text-blue-400">Edit</a>
                                            <span class="mx-2 text-gray-300 dark:text-gray-600">|</span>
                                            <a href="#"
                                                class="text-theme-sm text-red-600 hover:underline dark:text-red-400">Delete</a>
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
            <div>
                <a href="#"
                    class="inline-flex items-center gap-2 rounded bg-brand-500 px-3 py-2 text-sm text-white hover:bg-brand-600">+
                    Tambah Sensor</a>
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
                                    <td class="px-5 py-4 sm:px-6 text-center"><a href="#"
                                            class="text-theme-sm text-blue-600 hover:underline dark:text-blue-400">View</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-5 py-6 text-center text-sm text-gray-500">No sensor groups
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
@endsection
