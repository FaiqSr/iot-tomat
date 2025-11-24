@extends('layout.adminDashboard')

@section('title', 'Admin - Sensors')
@section('page', 'admin.sensors')
@section('pageName', 'Manage Sensors')

{{-- Tambahkan section breadcrumb agar navigasi di atas (sebelah judul) muncul --}}
@section('breadcrumb', 'Dashboard')

@section('content')
    <div class="rounded-sm border border-stroke bg-white dark:bg-gray-800 shadow-default dark:border-strokedark dark:bg-boxdark"
        style="color: black;">

        {{-- Card Header & Button --}}
        <div class="py-6 px-4 md:px-6 xl:px-7.5 flex items-center justify-between ">
            <h4 class="text-xl font-semibold text-black dark:text-white">
                Sensors List
            </h4>
            <a href="{{ route('admin.sensors.create') }}"
                class="inline-flex items-center justify-center gap-2.5 rounded-md bg-primary py-2 px-6 text-center font-medium text-white hover:bg-opacity-90 lg:px-8 xl:px-10">
                <span>
                    <svg class="fill-current w-4 h-4" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                    </svg>
                </span>
                Add New Sensor
            </a>
        </div>

        {{-- Table Section --}}
        <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-2 text-left dark:bg-meta-4">
                        <th class="min-w-[70px] py-4 px-4 font-medium text-black dark:text-white xl:pl-11">
                            ID
                        </th>
                        <th class="min-w-[220px] py-4 px-4 font-medium text-black dark:text-white">
                            Sensor Name
                        </th>
                        <th class="min-w-[150px] py-4 px-4 font-medium text-black dark:text-white">
                            Type
                        </th>
                        <th class="min-w-[120px] py-4 px-4 font-medium text-black dark:text-white">
                            Status
                        </th>
                        <th class="py-4 px-4 font-medium text-black dark:text-white">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sensors as $s)
                        <tr>
                            <td class="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                <h5 class="font-medium text-black dark:text-white">#{{ $s->id }}</h5>
                            </td>
                            <td class="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                <h5 class="font-medium text-black dark:text-white">{{ $s->name }}</h5>
                            </td>
                            <td class="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                <p class="text-black dark:text-white">{{ $s->type }}</p>
                            </td>
                            <td class="border-b border-[#eee] py-5 px-4 dark:border-strokedark ">
                                {{-- Logic Status dengan warna standar Tailwind agar lebih aman --}}
                                <p
                                    class="inline-flex rounded-full bg-opacity-10 py-1 px-3 text-sm font-medium
                                    {{ strtolower($s->status) == 'active'
                                        ? 'bg-green-500 text-green-100 dark:bg-green-700 dark:text-green-300'
                                        : 'bg-red-500 text-red-600 dark:bg-red-700 dark:text-red-300' }}">
                                    {{ $s->status }}
                                </p>
                            </td>
                            <td class="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                <div class="flex items-center space-x-3.5">
                                    {{-- Edit Button --}}
                                    <a href="{{ route('admin.sensors.edit', $s->id) }}" class="hover:text-primary">
                                        <svg class="fill-current w-5 h-5" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z" />
                                        </svg>
                                    </a>

                                    {{-- Delete Button --}}
                                    <form action="{{ route('admin.sensors.destroy', $s->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete {{ $s->name }}?')"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button class="hover:text-red-500 mt-1">
                                            <svg class="fill-current w-5 h-5" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-10 text-gray-500 dark:text-gray-400">
                                No sensors data found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="p-4 border-t border-stroke dark:border-strokedark">
            {{ $sensors->links() }}
        </div>
    </div>
@endsection
