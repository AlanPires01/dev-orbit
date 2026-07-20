<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cloud & Tech News Feed</title>
    <!-- Tailwind CSS via CDN para estilização rápida -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen">

    <header class="bg-slate-800 border-b border-slate-700 py-6 shadow-md">
        <div class="max-w-6xl mx-auto px-4 flex flex-col md:flex-row justify-between items-center gap-4">
            <h1 class="text-2xl font-bold tracking-wider text-cyan-400">🪐 DevOrbit</h1>            
            <!-- Filtros por Tags -->
            <nav class="flex flex-wrap gap-2">
                <a href="/?tag=aws" class="px-4 py-2 rounded text-sm font-medium transition {{ $tag == 'aws' ? 'bg-cyan-600 text-white' : 'bg-slate-700 hover:bg-slate-600' }}">AWS</a>
                <a href="/?tag=php" class="px-4 py-2 rounded text-sm font-medium transition {{ $tag == 'php' ? 'bg-cyan-600 text-white' : 'bg-slate-700 hover:bg-slate-600' }}">PHP / Laravel</a>
                <a href="/?tag=docker" class="px-4 py-2 rounded text-sm font-medium transition {{ $tag == 'docker' ? 'bg-cyan-600 text-white' : 'bg-slate-700 hover:bg-slate-600' }}">Docker</a>
                <a href="/?tag=devops" class="px-4 py-2 rounded text-sm font-medium transition {{ $tag == 'devops' ? 'bg-cyan-600 text-white' : 'bg-slate-700 hover:bg-slate-600' }}">DevOps</a>
            </nav>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($articles as $article)
                <article class="bg-slate-800 border border-slate-700 rounded-lg overflow-hidden flex flex-col justify-between hover:border-cyan-500 transition shadow-lg">
                    <div>
                        @if(!empty($article['cover_image']))
                            <img src="{{ $article['cover_image'] }}" alt="Capa" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-slate-700 flex items-center justify-center text-slate-500 font-semibold">Sem Imagem</div>
                        @endif
                        
                        <div class="p-5">
                            <span class="text-xs font-semibold uppercase tracking-wider text-cyan-400 bg-cyan-950 px-2 py-1 rounded">
                                {{ $article['readable_publish_date'] ?? 'Recente' }}
                            </span>
                            <h2 class="text-xl font-bold mt-3 mb-2 text-slate-100 line-clamp-2">{{ $article['title'] }}</h2>
                            <p class="text-slate-400 text-sm line-clamp-3">{{ $article['description'] }}</p>
                        </div>
                    </div>

                    <div class="p-5 pt-0 flex items-center justify-between border-t border-slate-700/50 mt-4">
                        <span class="text-xs text-slate-400">Por {{ $article['user']['name'] ?? 'Autor' }}</span>
                        <a href="{{ $article['url'] }}" target="_blank" class="text-sm font-medium text-cyan-400 hover:underline">Ler Artigo &rarr;</a>
                    </div>
                </article>
            @empty
                <div class="col-span-full text-center py-12 text-slate-400">
                    Nenhum artigo encontrado para esta categoria no momento.
                </div>
            @endforelse
        </div>
    </main>

</body>
</html>