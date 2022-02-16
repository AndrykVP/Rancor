<div class="container flex flex-wrap items-center justify-center mx-auto space-y-4 sm:justify-between sm:space-y-0">
   <p class="text-xs">
	   <span class="text-gray-500">Online Users:</span>
	   @foreach($users as $user)
	   <a href="{{ route('profile.show', $user) }}" class="text-indigo-800 hover:text-indigo-600">{{ $user->name }}</a>,
	   @endforeach
   </p>
</div>