<x-select name="month" label="Pilih Bulan" wire:model="month">
    @foreach (range(1, 12) as $monthNumber)
        <option value="{{ $monthNumber }}">{{ \Carbon\Carbon::createFromFormat('m', $monthNumber)->format('F') }}</option>
    @endforeach
</x-select>