<x-layouts.app title="Edit Poli">

    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('polis.index') }}"
            class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-slate-100 text-slate-500 hover:bg-slate-200 transition">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>
        <h2 class="text-2xl font-bold text-slate-800">Edit Poli</h2>
    </div>

    <div class="card bg-base-100 shadow-md rounded-2xl border border-slate-200">
        <div class="card-body p-8">
            <form action="{{ route('polis.update', $poli->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-5">
                    <label for="nama_poli" class="block text-sm font-semibold text-slate-700 mb-1">
                        Nama Poli <span class="text-red-500">*</span>
                    </label>
                    <input id="nama_poli" type="text" name="nama_poli"
                        value="{{ old('nama_poli', $poli->nama_poli) }}"
                        class="input input-bordered w-full rounded-lg @error('nama_poli') input-error @enderror"
                        required>
                    @error('nama_poli')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-8">
                    <label for="keterangan" class="block text-sm font-semibold text-slate-700 mb-1">
                        Keterangan
                    </label>
                    <textarea id="keterangan" name="keterangan" rows="4"
                        class="textarea textarea-bordered w-full rounded-lg @error('keterangan') textarea-error @enderror">{{ old('keterangan', $poli->keterangan) }}</textarea>
                    @error('keterangan')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3">
                    <button type="submit"
                        class="px-6 py-2.5 rounded-lg bg-[#4f35d2] hover:bg-[#4029b5] text-white font-semibold text-sm transition">
                        <i class="fas fa-save mr-1"></i>
                        Simpan
                    </button>
                    <a href="{{ route('polis.index') }}"
                        class="px-6 py-2.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold text-sm transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

</x-layouts.app>
