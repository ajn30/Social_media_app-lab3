@props(['type', 'message'])

<div class="mb-4 {{ $type === 'success' ? 'bg-green-100 border-green-400 text-green-700' : 'bg-red-100 border-red-400 text-red-700' }} border px-4 py-3 rounded relative" role="alert">
    <strong class="font-bold">{{ ucfirst($type) }}!</strong>
    <span class="block sm:inline">{{ $message }}</span>
</div>