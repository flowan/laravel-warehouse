<x-filament-panels::page>

    <div class="fi-ta-ctn divide-y divide-gray-200 overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:divide-white/10 dark:bg-gray-900 dark:ring-white/10">
        <div class="fi-ta-content divide-y divide-gray-200 overflow-x-auto dark:divide-white/10 dark:border-t-white/10">

            <div class="fi-ta-header flex gap-1.5 p-4 text-sm">
                <x-filament::link color="gray" href="?path=">
                    {{ $this->getRecord()->name }}
                </x-filament::link>

                @foreach($breadcrumbs as $breadcrumb)
                    <span class="text-gray-400">></span>
                    <x-filament::link color="gray" href="?path={{ $breadcrumb->path }}">
                        {{ $breadcrumb->name }}
                    </x-filament::link>
                @endforeach
            </div>

            <x-filament-tables::table>
                <x-slot name="header">
                    <x-filament-tables::header-cell>Name</x-filament-tables::header-cell>
                    <x-filament-tables::header-cell>Size</x-filament-tables::header-cell>
                    <x-filament-tables::header-cell>Last Modified</x-filament-tables::header-cell>
                </x-slot>

                @foreach($directories as $directory)
                    <tr class="fi-ta-row [@media(hover:hover)]:transition [@media(hover:hover)]:duration-75 hover:bg-gray-50 dark:hover:bg-white/5">
                        <td class="fi-ta-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 fi-table-cell-name">
                            <div class="fi-ta-col-wrp flex items-center">
                                <x-filament::icon
                                    icon="heroicon-o-folder"
                                    class="h-6 w-6 text-gray-400 dark:text-gray-500"
                                />
                                <a href="?path={{ $directory->path }}" class="fi-ta-text inline-block w-full px-3 py-3 text-sm">{{ $directory->name }}</a>
                            </div>
                        </td>
                        <td class="fi-ta-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 fi-table-cell-user.name">
                            <div class="fi-ta-col-wrp">

                            </div>
                        </td>
                        <td class="fi-ta-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 fi-table-cell-visibility">
                            <div class="fi-ta-col-wrp">

                            </div>
                        </td>
                    </tr>
                @endforeach

                @foreach($files as $file)
                    <tr class="fi-ta-row [@media(hover:hover)]:transition [@media(hover:hover)]:duration-75 hover:bg-gray-50 dark:hover:bg-white/5">
                        <td class="fi-ta-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 fi-table-cell-name">
                            <div class="fi-ta-col-wrp flex items-center">
                                <x-filament::icon
                                    icon="heroicon-o-document"
                                    class="h-6 w-6 text-gray-400 dark:text-gray-500"
                                />
                                <span class="fi-ta-text text-sm inline-block px-3 py-3">{{ $file->name }}</span>
                            </div>
                        </td>
                        <td class="fi-ta-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 fi-table-cell-user.name">
                            <div class="fi-ta-col-wrp">
                                <span class="fi-ta-text text-sm inline-block px-3 py-3">{{ $file->size }}</span>
                            </div>
                        </td>
                        <td class="fi-ta-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 fi-table-cell-visibility">
                            <div class="fi-ta-col-wrp">
                                <span class="fi-ta-text text-sm inline-block px-3 py-3">{{ $file->last_modified }}</span>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-filament-tables::table>

        </div>
    </div>

</x-filament-panels::page>
