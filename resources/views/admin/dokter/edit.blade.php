<x-layouts.app title="Edit Dokter">

    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('dokter.index') }}"
            class="flex items-center justify-center w-9 h-9 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 transition">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>
        <h2 class="text-2xl font-bold text-slate-800">Edit Dokter</h2>
    </div>

    <div class="card bg-base-100 shadow-md rounded-2xl border border-slate-200">
        <div class="card-body p-8">
            <form action="{{ route('dokter.update', $dokter->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Dokter</label>
                        <input type="text" name="nama" value="{{ old('nama', $dokter->nama) }}" required
                            class="w-full px-4 py-2 rounded-lg border-2 focus:border-primary focus:outline-none @error('nama') border-red-500 @enderror">
                        @error('nama') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email', $dokter->email) }}" required
                            class="w-full px-4 py-2 rounded-lg border-2 focus:border-primary focus:outline-none @error('email') border-red-500 @enderror">
                        @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">No. KTP</label>
                        <input type="number" name="no_ktp" value="{{ old('no_ktp', $dokter->no_ktp) }}" required
                            class="w-full px-4 py-2 rounded-lg border-2 focus:border-primary focus:outline-none @error('no_ktp') border-red-500 @enderror">
                        @error('no_ktp') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">No. HP</label>
                        <input type="number" name="no_hp" value="{{ old('no_hp', $dokter->no_hp) }}" required
                            class="w-full px-4 py-2 rounded-lg border-2 focus:border-primary focus:outline-none @error('no_hp') border-red-500 @enderror">
                        @error('no_hp') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Alamat</label>
                    <textarea name="alamat" rows="3" required
                        class="w-full px-4 py-2 rounded-lg border-2 focus:border-primary focus:outline-none @error('alamat') border-red-500 @enderror">{{ old('alamat', $dokter->alamat) }}</textarea>
                    @error('alamat') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Poli</label>
                    <select name="id_poli" required
                        class="w-full px-4 py-2 rounded-lg border-2 focus:border-primary focus:outline-none @error('id_poli') border-red-500 @enderror">
                        <option value="">Pilih Poli</option>
                        @foreach($polis as $poli)
                        <option value="{{ $poli->id }}" {{ (string) old('id_poli', $dokter->id_poli) === (string) $poli->id ? 'selected' : '' }}>
                            {{ $poli->nama_poli }}
                        </option>
                        @endforeach
                    </select>
                    @error('id_poli') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-8">
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Password</label>
                    <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah..."
                        class="w-full px-4 py-2 rounded-lg border-2 focus:border-primary focus:outline-none @error('password') border-red-500 @enderror">
                    @error('password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex gap-3">
                    <button type="submit"
                        class="px-6 py-2.5 rounded-lg bg-primary hover:bg-primary/90 text-white font-semibold text-sm transition">
                        <i class="fas fa-save mr-1"></i> Update
                    </button>
                    <a href="{{ route('dokter.index') }}"
                        class="px-6 py-2.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold text-sm transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

</x-layouts.app>
