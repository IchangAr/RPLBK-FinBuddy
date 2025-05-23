@props(['disabled' => false])

<input @disabled($disabled)
    {{ $attributes->merge([
        'class' => 'block w-full rounded-lg border border-gray-300 bg-white px-4 py-1.5 text-base text-gray-900
               shadow-sm placeholder-gray-400
               focus:border-[#3B577D] focus:ring-2 focus:ring-[#3B577D] focus:outline-none
               transition duration-200 ease-in-out',
    ]) }}>
