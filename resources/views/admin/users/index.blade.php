@extends('layout.adminDashboard')

@section('title', 'Admin - Users')
@section('page', 'admin.users')
@section('pageName', 'Manage Users')

@section('content')
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between ">
        <h2 class="text-title-md2 font-semibold text-black dark:text-white">
            Users Management
        </h2>
        <nav>
            <ol class="flex items-center gap-2 text-black dark:text-white">
                <li><a class="font-medium" href="/admin">Dashboard /</a></li>
                <li class="font-medium text-primary">Users</li>
            </ol>
        </nav>
    </div>
    <div
        class="rounded-lg border border-stroke border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-5 pt-6 pb-2.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">

        {{-- Header Card: Title & Add Button --}}
        <div class="flex justify-between items-center mb-6">
            <h4 class="text-xl font-semibold text-black dark:text-white">
                All Users
            </h4>
            <a href="{{ route('admin.users.create') }}"
                class="inline-flex items-center justify-center rounded bg-blue-600 py-2 px-6 text-center font-medium text-white hover:bg-opacity-90 lg:px-8 xl:px-10 transition">
                <span>
                    <svg class="fill-current w-4 h-4 mr-2" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                    </svg>
                </span>
                New User
            </a>
        </div>

        {{-- Table Section --}}
        <div class="max-w-full overflow-x-auto border-t border-gray-200 dark:border-gray-700 pt-4">
            <table class="w-full table-auto">
                <thead class="border-b border-gray-200 dark:border-gray-700">
                    <tr class="bg-gray-2 text-left dark:bg-meta-4">
                        <th class="min-w-[50px] py-4 px-4 font-medium text-black dark:text-white xl:pl-11">
                            #
                        </th>
                        <th class="min-w-[150px] py-4 px-4 font-medium text-black dark:text-white">
                            Name
                        </th>
                        <th class="min-w-[220px] py-4 px-4 font-medium text-black dark:text-white">
                            Email
                        </th>
                        <th class="min-w-[120px] py-4 px-4 font-medium text-black dark:text-white">
                            Role
                        </th>
                        <th class="py-4 px-4 font-medium text-black dark:text-white text-center">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $u)
                        <tr>
                            <td
                                class="border-b border-gray-200 dark:border-gray-700 py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                <h5 class="font-medium text-black dark:text-white">
                                    {{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</h5>
                            </td>
                            <td class="border-b border-gray-200 dark:border-gray-700 py-5 px-4 dark:border-strokedark">
                                <h5 class="font-medium text-black dark:text-white">
                                    {{ $u->first_name }} {{ $u->last_name }}
                                </h5>
                            </td>
                            <td class="border-b border-gray-200 dark:border-gray-700 py-5 px-4 dark:border-strokedark">
                                <p class="text-black dark:text-white">{{ $u->email }}</p>
                            </td>
                            <td class="border-b border-gray-200 dark:border-gray-700 py-5 px-4 dark:border-strokedark">
                                {{-- Logic sederhana untuk warna badge berdasarkan role --}}
                                @php
                                    $roleColor = match ($u->role) {
                                        'admin' => 'bg-red-100 text-red-600',
                                        'editor' => 'bg-blue-100 text-blue-600',
                                        default => 'bg-green-100 text-green-600',
                                    };
                                @endphp
                                <span
                                    class="inline-flex rounded-full bg-opacity-10 py-1 px-3 text-sm font-medium {{ $roleColor }}">
                                    {{ ucfirst($u->role ?? 'User') }}
                                </span>
                            </td>
                            <td
                                class="border-b border-gray-200 dark:border-gray-700 text-dark dark:text-white py-5 px-4 dark:border-strokedark">
                                <div class="flex items-center justify-center space-x-3.5">
                                    {{-- Edit Button --}}
                                    <a href="{{ route('admin.users.edit', $u->id) }}" class="hover:text-primary transition"
                                        title="Edit">
                                        <svg class="fill-current w-5 h-5" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z" />
                                        </svg>
                                    </a>

                                    {{-- Delete Button --}}
                                    <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this user?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="hover:text-red-600 transition" title="Delete">
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
                            <td colspan="5" class="py-5 px-4 text-center text-gray-500 dark:text-gray-400">
                                No users found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($users->hasPages())
            <div
                class="flex flex-col items-center border-t border-stroke px-5 py-5 dark:border-strokedark sm:flex-row sm:justify-between">
                <div class="text-sm text-gray-500">
                    Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} entries
                </div>
                <div class="mt-2 sm:mt-0">
                    {{ $users->links('pagination::tailwind') }}
                </div>
            </div>
        @endif
    </div>
@endsection
