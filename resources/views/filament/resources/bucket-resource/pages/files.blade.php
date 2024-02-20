<x-filament-panels::page>

    <x-filament-tables::container>
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
                    <x-filament-tables::header-cell></x-filament-tables::header-cell>
                </x-slot>

                @foreach($directories as $directory)
                    <x-filament-tables::row>
                        <x-filament-tables::cell colspan="4">
                            <div class="fi-ta-col-wrp flex items-center">
                                <x-filament::icon
                                    icon="heroicon-o-folder"
                                    class="h-6 w-6 text-primary-600 dark:text-primary-400"
                                />
                                <a href="?path={{ $directory->path }}" class="fi-ta-text inline-block w-full px-3 py-3 text-sm">{{ $directory->name }}</a>
                            </div>
                        </x-filament-tables::cell>
                    </x-filament-tables::row>
                @endforeach

                @foreach($files as $file)
                    <x-filament-tables::row>
                        <x-filament-tables::cell>
                            <div class="fi-ta-col-wrp flex items-center">
                                <x-filament::icon
                                    icon="heroicon-o-document"
                                    class="h-6 w-6 text-gray-400 dark:text-gray-500"
                                />
                                <span class="fi-ta-text text-sm inline-block px-3 py-3">{{ $file->name }}</span>
                            </div>
                        </x-filament-tables::cell>
                        <x-filament-tables::cell>
                            <div class="fi-ta-col-wrp">
                                <span class="fi-ta-text text-sm inline-block px-3 py-3">{{ $file->size }}</span>
                            </div>
                        </x-filament-tables::cell>
                        <x-filament-tables::cell>
                            <div class="fi-ta-col-wrp">
                                <span class="fi-ta-text text-sm inline-block px-3 py-3">{{ $file->last_modified }}</span>
                            </div>
                        </x-filament-tables::cell>
                        <x-filament-tables::cell>
                            <div class="fi-ta-col-wrp whitespace-nowrap">
                                <span class="fi-ta-text text-sm inline-block px-3 py-3">
                                    <x-filament::link
                                        color="gray"
                                        href="{{ $file->url }}"
                                        icon="heroicon-o-arrow-top-right-on-square"
                                        iconSize="sm"
                                        rel="noopener"
                                        target="_blank"
                                    >
                                        View
                                    </x-filament::link>
                                </span>
                            </div>
                        </x-filament-tables::cell>
                    </x-filament-tables::row>
                @endforeach
            </x-filament-tables::table>

        </div>
    </x-filament-tables::container>

</x-filament-panels::page>
