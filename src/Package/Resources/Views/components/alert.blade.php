<div
x-data="{show: true}"
x-init="setTimeout(() => show = false, {{ $timeout }})"
x-show="show"
x-transition:enter="transition ease-out duration-200"
x-transition:enter-start="transform opacity-0 scale-95"
x-transition:enter-end="transform opacity-100 scale-100"
x-transition:leave="transition ease-in duration-75"
x-transition:leave-start="transform opacity-100 scale-100"
x-transition:leave-end="transform opacity-0 scale-95"
class="text-white px-6 py-4 border-0 rounded absolute z-10 top-12 right-12 bg-{{ $color }}-500">
	<span class="text-xl inline-block mr-5 align-middle">
		<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
			<path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
		</svg>
	</span>
	<span class="inline-block align-middle mr-8">
		{{ $message }}
	</span>
	<button @click="show = false" class="absolute bg-transparent text-2xl font-semibold leading-none right-0 top-0 mt-4 mr-6 outline-none focus:outline-none">
		<span>×</span>
	</button>
</div>