@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between">
        <div class="flex justify-between flex-1 sm:hidden">
            @if ($paginator->onFirstPage())
                <span
                    class="relative inline-flex items-center px-4 py-2 mr-2 text-sm font-semibold text-white bg-white border border-[#303030] cursor-default leading-5 dark:text-white dark:bg-[#222] dark:border-[#303030]">
                    {!! __('pagination.previous') !!}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                   class="relative inline-flex items-center px-4 py-2 mr-2 text-sm font-semibold text-white bg-white border border-[#303030] leading-5 hover:text-white focus:outline-none focus:ring ring-gray-300 focus:border-[#303030] active:bg-[#F84453] active:text-black transition ease-in-out duration-150 dark:bg-[#222] dark:border-[#303030] dark:text-white dark:focus:border-[#303030] dark:active:text-black">
                    {!! __('pagination.previous') !!}
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                   class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-semibold text-white bg-white border border-[#303030] leading-5 hover:text-white focus:outline-none focus:ring ring-gray-300 focus:border-[#303030] active:bg-[#F84453] active:text-black transition ease-in-out duration-150 dark:bg-[#222] dark:border-[#303030] dark:text-white dark:focus:border-[#303030] dark:active:text-black">
                    {!! __('pagination.next') !!}
                </a>
            @else
                <span
                    class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-semibold text-white bg-white border border-[#303030] cursor-default leading-5 dark:text-white dark:bg-[#222] dark:border-[#303030]">
                    {!! __('pagination.next') !!}
                </span>
            @endif
        </div>

        <div class="py-6 hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <span class="relative z-0 inline-flex rtl:flex-row-reverse shadow-sm">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                            <span
                                class="relative inline-flex items-center px-2 py-2 mr-2 text-sm font-bold text-white bg-white border border-[#303030] cursor-default leading-5 dark:bg-[#222] dark:border-[#303030]"
                                aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                     class="bi bi-chevron-left" viewBox="0 0 16 16">
                                  <path fill-rule="evenodd"
                                        d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0"/>
                                </svg>
                            </span>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                           class="relative inline-flex items-center px-2 py-2 mr-2 text-sm font-bold text-white bg-white border border-[#303030] leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-[#303030] active:bg-[#F84453] active:text-black transition ease-in-out duration-150 dark:bg-[#222] dark:border-[#303030] dark:focus:border-[#303030]"
                           aria-label="{{ __('pagination.previous') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-chevron-left" viewBox="0 0 16 16">
                              <path fill-rule="evenodd"
                                    d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0"/>
                            </svg>
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span aria-disabled="true">
                                <span
                                    class="relative inline-flex items-center px-4 py-2 mr-2 -ml-px text-sm font-semibold text-white bg-white border border-[#303030] cursor-default leading-5 dark:bg-[#222] dark:border-[#303030]">{{ $element }}</span>
                            </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page">
                                        <span
                                            class="relative inline-flex items-center px-4 py-2 mr-2 -ml-px text-sm font-semibold text-white bg-white border border-[#303030] cursor-default leading-5 dark:bg-[#F84453] dark:text-black dark:border-[#303030]">{{ $page }}</span>
                                    </span>
                                @else
                                    <a href="{{ $url }}"
                                       class="relative inline-flex items-center px-4 py-2 mr-2 -ml-px text-sm font-semibold text-white bg-white border border-[#303030] leading-5 hover:text-black focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-[#303030] transition ease-in-out duration-150 dark:bg-[#222] dark:border-[#303030] dark:text-white dark:hover:text-gray-300 dark:focus:border-[#303030]"
                                       aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                           class="relative inline-flex items-center px-2 py-2 mr-2 -ml-px text-sm font-bold text-white bg-white border border-[#303030] leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-[#303030] active:bg-[#F84453] active:text-black transition ease-in-out duration-150 dark:bg-[#222] dark:border-[#303030] dark:focus:border-[#303030]"
                           aria-label="{{ __('pagination.next') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-chevron-right" viewBox="0 0 16 16">
                              <path fill-rule="evenodd"
                                    d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708"/>
                            </svg>
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                            <span
                                class="relative inline-flex items-center px-2 py-2 mr-2 -ml-px text-sm font-bold text-white bg-white border border-[#303030] cursor-default leading-5 dark:bg-[#222] dark:border-[#303030]"
                                aria-hidden="true">
                               <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-chevron-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                      d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708"/>
                               </svg>
                            </span>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
