@props([
    "title",
    "pages",
    "downloadUrl",
    "eyebrow" => null,
])

<section
    data-pdf-page-grid
    aria-label="{{ $title }}"
    {{ $attributes }}
>
    <div class="mb-5 flex items-end justify-between gap-4">
        <div>
            @if ($eyebrow)
                <p class="text-sm font-semibold text-[#7D3C98]">
                    {{ $eyebrow }}
                </p>
            @endif

            <h2 class="text-2xl font-bold text-slate-900">
                {{ $title }}
            </h2>
        </div>

        <a
            href="{{ $downloadUrl }}"
            download
            class="shrink-0 text-sm font-semibold text-[#7D3C98] hover:underline"
        >
            Download PDF
        </a>
    </div>

    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
        @foreach ($pages as $pageUrl)
            @php
                $pageTitle = "{$title} — {$loop->iteration}";
            @endphp

            <button
                type="button"
                data-pdf-page
                data-page-src="{{ $pageUrl }}"
                data-page-title="{{ $pageTitle }}"
                aria-label="Expand {{ $pageTitle }}"
                class="group overflow-hidden rounded-lg border border-slate-200 bg-white text-left shadow-sm transition hover:-translate-y-1 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-[#7D3C98] focus:ring-offset-2"
            >
                <span class="block aspect-[210/297] overflow-hidden bg-slate-100">
                    <img
                        src="{{ $pageUrl }}"
                        alt="{{ $pageTitle }}"
                        width="1191"
                        height="1684"
                        loading="lazy"
                        decoding="async"
                        class="h-full w-full object-cover transition duration-200 group-hover:scale-[1.02]"
                    />
                </span>
                <span class="block px-3 py-3 text-center">
                    <span class="text-sm font-semibold text-slate-700">
                        {{ $loop->iteration }}
                    </span>
                </span>
            </button>
        @endforeach
    </div>

    <dialog
        data-pdf-dialog
        aria-label="Expanded page from {{ $title }}"
        class="m-auto h-[95vh] w-[95vw] max-w-6xl overflow-hidden rounded-xl bg-slate-900 p-0 text-white shadow-2xl backdrop:bg-slate-950/90"
    >
        <div class="flex h-full flex-col">
            <header class="flex shrink-0 items-center justify-between gap-4 border-b border-white/10 px-4 py-3">
                <p data-dialog-title class="truncate font-semibold"></p>
                <button
                    type="button"
                    data-dialog-close
                    aria-label="Close expanded page"
                    class="rounded-lg p-2 text-slate-300 hover:bg-white/10 hover:text-white focus:outline-none focus:ring-2 focus:ring-white"
                >
                    <svg
                        aria-hidden="true"
                        class="h-6 w-6"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                    >
                        <path d="M5.28 4.22a.75.75 0 0 0-1.06 1.06L8.94 10l-4.72 4.72a.75.75 0 1 0 1.06 1.06L10 11.06l4.72 4.72a.75.75 0 1 0 1.06-1.06L11.06 10l4.72-4.72a.75.75 0 0 0-1.06-1.06L10 8.94 5.28 4.22Z" />
                    </svg>
                </button>
            </header>

            <div class="min-h-0 flex-1 overflow-auto bg-slate-800 p-3 sm:p-6">
                <img
                    data-dialog-image
                    alt=""
                    class="mx-auto block h-auto w-full max-w-[1191px] bg-white shadow-xl"
                />
            </div>
        </div>
    </dialog>
</section>

@once
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('[data-pdf-page-grid]').forEach((grid) => {
                const dialog = grid.querySelector('[data-pdf-dialog]');
                const dialogImage = grid.querySelector('[data-dialog-image]');
                const dialogTitle = grid.querySelector('[data-dialog-title]');

                grid.addEventListener('click', (event) => {
                    const page = event.target.closest('[data-pdf-page]');

                    if (! page) return;

                    dialogImage.src = page.dataset.pageSrc;
                    dialogImage.alt = page.dataset.pageTitle;
                    dialogTitle.textContent = page.dataset.pageTitle;
                    document.body.classList.add('overflow-hidden');
                    dialog.showModal();
                });

                grid
                    .querySelector('[data-dialog-close]')
                    .addEventListener('click', () => dialog.close());

                dialog.addEventListener('click', (event) => {
                    if (event.target === dialog) dialog.close();
                });

                dialog.addEventListener('close', () => {
                    document.body.classList.remove('overflow-hidden');
                    dialogImage.removeAttribute('src');
                });
            });
        });
    </script>
@endonce
