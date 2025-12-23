@extends('layouts.dashboard')

@section('title', 'Mengerjakan Tes - ' . $category->nama_kategori)

@section('sidebar')
    @include('layouts.partials.sidebar-talent')
@endsection

@section('content')
    <div class="max-w-4xl mx-auto pb-12">
        <div class="mb-8">
            <h2 class="text-2xl font-bold">{{ $category->nama_kategori }}</h2>
            <p class="text-slate-500">Pilih jawaban yang menurut Anda paling tepat.</p>
        </div>

        <form action="{{ route('talent.skill-tests.submit', $category->id) }}" method="POST" class="space-y-6"
            x-data="{ submitting: false }" @submit="submitting = true">
            @csrf
            @foreach($questions as $index => $q)
                <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm border border-slate-200 dark:border-slate-700">
                    <div class="flex gap-4">
                        <span
                            class="size-8 rounded-lg bg-primary/10 text-primary flex items-center justify-center font-bold shrink-0">
                            {{ $index + 1 }}
                        </span>
                        <div class="flex-1">
                            <p class="font-medium text-slate-900 dark:text-white mb-6 text-lg">{{ $q->pertanyaan }}</p>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach(['a', 'b', 'c', 'd'] as $opt)
                                    @php $field = "opsi_" . $opt; @endphp
                                    <label
                                        class="relative flex items-center p-4 border border-slate-200 dark:border-slate-700 rounded-xl cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-900/50 transition-all has-[:checked]:border-primary has-[:checked]:bg-primary/5 group">
                                        <input type="radio" name="answers[{{ $q->id }}]" value="{{ strtoupper($opt) }}"
                                            class="opacity-0 absolute" required>
                                        <div
                                            class="size-5 rounded-full border-2 border-slate-300 peer-checked:border-primary peer-checked:bg-primary mr-3 flex items-center justify-center transition-all">
                                            <div class="size-2 bg-white rounded-full opacity-0 peer-checked:opacity-100"></div>
                                        </div>
                                        <span class="text-slate-700 dark:text-slate-300 font-medium">{{ $q->$field }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="flex justify-end pt-6">
                <button type="submit" :disabled="submitting"
                    class="px-10 py-4 bg-primary text-white rounded-2xl font-bold shadow-xl shadow-primary/30 hover:bg-blue-600 transition-all flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                    <template x-if="!submitting">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined">check_circle</span>
                            <span>Selesaikan Tes</span>
                        </div>
                    </template>
                    <template x-if="submitting">
                        <div class="flex items-center gap-2">
                            <span class="animate-spin material-symbols-outlined">progress_activity</span>
                            <span>Mengirim...</span>
                        </div>
                    </template>
                </button>
            </div>
        </form>
    </div>
@endsection