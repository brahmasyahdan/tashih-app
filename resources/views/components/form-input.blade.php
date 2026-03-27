@props(['label', 'name', 'type' => 'text', 'value' => '', 'required' => false, 'placeholder' => ''])

<div class="mb-4">
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-1">
        {{ $label }}
        @if($required) <span class="text-red-500">*</span> @endif
    </label>
    <input 
        type="{{ $type }}"
        id="{{ $name }}"
        name="{{ $name }}"
        value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}
        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm
               focus:outline-none focus:ring-2 focus:ring-hijau-500 focus:border-hijau-500
               @error($name) border-red-400 @enderror"
    >
    @error($name)
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>