@props(['id' => null, 'name' => null, 'class' => ''])

<select 
    @if($id) id="{{ $id }}" @endif
    @if($name) name="{{ $name }}" @endif
    {{ $attributes->merge(['class' => 'rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 ' . $class]) }}
>
    {{ $slot }}
</select>
