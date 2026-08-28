<x-layout>
    @php
        $newsletters = [
            [
                "issue" => "008",
                "month" => "April 2026",
                "folder" => "april-2026",
                "pdf" => "News_April 2026.pdf",
            ],
            [
                "issue" => "007",
                "month" => "March 2026",
                "folder" => "march-2026",
                "pdf" => "News_March 2026.pdf",
            ],
            [
                "issue" => "006",
                "month" => "February 2026",
                "folder" => "february-2026",
                "pdf" => "News_February 2026.pdf",
            ],
            [
                "issue" => "005",
                "month" => "January 2026",
                "folder" => "january-2026",
                "pdf" => "News_January 2026.pdf",
            ],
            [
                "issue" => "004",
                "month" => "December 2025",
                "folder" => "december-2025",
                "pdf" => "News_December 2025.pdf",
            ],
            [
                "issue" => "003",
                "month" => "November 2025",
                "folder" => "november-2025",
                "pdf" => "News_November 2025.pdf",
            ],
            [
                "issue" => "002",
                "month" => "October 2025",
                "folder" => "october-2025",
                "pdf" => "News_October 2025.pdf",
            ],
            [
                "issue" => "001",
                "month" => "September 2025",
                "folder" => "september-2025",
                "pdf" => "News_September 2025.pdf",
            ],
        ];
    @endphp

    <div class="min-h-screen bg-slate-50">
        <header class="bg-[#7D3C98] text-white">
            <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
                <a
                    href="{{ route("guest") }}"
                    class="inline-flex items-center gap-2 text-sm text-purple-100 hover:text-white"
                >
                    <span aria-hidden="true">&larr;</span>
                    Back to home
                </a>
                <h1 class="mt-6 text-4xl font-bold">GLCC Newsletter</h1>
                <p class="mt-2 text-purple-100">
                    Select a page to view it full size.
                </p>
            </div>
        </header>

        <main class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
            @foreach ($newsletters as $newsletter)
                @php
                    $pages = collect(range(1, 4))
                        ->map(fn ($page) => asset("images/newsletters/{$newsletter["folder"]}/page-{$page}.png"))
                        ->all();
                @endphp

                <div
                    @class([
                        "mt-12 border-t border-slate-200 pt-10" => ! $loop->first,
                    ])
                >
                    <x-pdf-page-grid
                        :title="$newsletter['month']"
                        :eyebrow="'Issue '.$newsletter['issue']"
                        :pages="$pages"
                        :download-url="asset('images/'.$newsletter['pdf'])"
                    />
                </div>
            @endforeach
        </main>
    </div>
</x-layout>
