@extends('rancor::layouts.main')

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-8">
         <div class="card mb-4">
            <div class="card-header">
               {{ __('Edit User') }}
            </div>
            <div class="card-body">
               <form action="{{ route('users.update', $user)}}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <input type="hidden" name="id" value="{{ $user->id }}">
                  @method('PATCH')
                  <div class="form-group">
                     <label for="name">Handle</label>
                     <input type="text" class="form-control @error('name')border border-danger @enderror" name="name" id="name" aria-describedby="nameHelp" placeholder="Enter a new name" autofocus value="{{ old('name') ? old('name') : $user->name }}">
                     @error('name')
                     <small id="nameHelp" class="form-text text-danger">{{ $message }}</small>
                     @enderror
                  </div>
                  <div class="form-group">
                     <label for="nickname">Nickname</label>
                     <input type="text" class="form-control @error('nickname')border border-danger @enderror" name="nickname" id="nickname" aria-describedby="nicknameHelp" placeholder="Enter a new nickname" value="{{ old('nickname') ? old('nickname') : $user->nickname }}">
                     @error('nickname')
                     <small id="nicknameHelp" class="form-text text-danger">{{ $message }}</small>
                     @enderror
                  </div>
                  <div class="form-group">
                     <label for="email">Email</label>
                     <input type="email" class="form-control @error('email')border border-danger @enderror" name="email" id="email" aria-describedby="emailHelp" placeholder="Enter a new email" value="{{ old('email') ? old('email') : $user->email }}">
                     @error('email')
                     <small id="emailHelp" class="form-text text-danger">{{ $message }}</small>
                     @enderror
                  </div>
                  <div class="form-group">
                     <label for="quote">Quote</label>
                     <input type="text" class="form-control @error('quote')border border-danger @enderror" name="quote" id="quote" aria-describedby="quoteHelp" placeholder="Enter a new quote" value="{{ old('quote') ? old('quote') : $user->quote }}">
                     @error('quote')
                     <small id="quoteHelp" class="form-text text-danger">{{ $message }}</small>
                     @enderror
                  </div>
                  @can('changeRank', $user)
                     <div class="form-group">
                        <label for="faction">Faction</label>
                        <select class="form-control @error('faction')border border-danger @enderror" id="faction" aria-describedby="factionHelp">
                           @foreach($factions as $faction)
                           <option value="{{ $faction->id }}" {{ $user->rank->department->faction->id == $faction->id ? 'selected' : ''}}>{{ $faction->name}}</option>
                           @endforeach
                        </select>
                        @error('faction')
                        <small id="factionHelp" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                     </div>
                     <div class="form-group">
                        <label for="department">Department</label>
                        <select class="form-control @error('department')border border-danger @enderror" id="department" aria-describedby="departmentHelp">
                           @foreach($departments as $department)
                           <option value="{{ $department->id }}" {{ $user->rank->department->id == $department->id ? 'selected' : ''}}>{{ $department->name}}</option>
                           @endforeach
                        </select>
                        @error('department')
                        <small id="departmentHelp" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                     </div>
                     <div class="form-group">
                        <label for="rank">Rank</label>
                        <select class="form-control @error('rank')border border-danger @enderror" name="rank_id" id="rank" aria-describedby="rankHelp">
                           @foreach($ranks as $rank)
                           <option value="{{ $rank->id }}" {{ $user->rank->id == $rank->id ? 'selected' : ''}}>{{ $rank->name}}</option>
                           @endforeach
                        </select>
                        @error('rank')
                        <small id="rankHelp" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                     </div>
                  @endcan
                  @can('uploadArt', $user)
                     <div class="form-group">
                        <label for="avatar">Avatar</label>
                        <div class="custom-file">
                           <input type="file" accept="image/png" class="custom-file-input @error('avatar')border border-danger @enderror" name="avatar" id="avatar" aria-describedby="avatarHelp">
                           <label class="custom-file-label" for="avatar">Choose 150x150px PNG image no bigger than 1MB</label>
                           @error('avatar')
                           <small id="avatarHelp" class="form-text text-danger">{{ $message }}</small>
                           @enderror
                        </div>
                     </div>
                     <div class="form-group">
                        <label for="signature">Signature</label>
                        <div class="custom-file">
                           <input type="file" accept="image/png" class="custom-file-input @error('signature')border border-danger @enderror" name="signature" id="signature" aria-describedby="signatureHelp">
                           <label class="custom-file-label" for="signature">Choose 150x150px PNG image no bigger than 1MB</label>
                           @error('signature')
                           <small id="signatureHelp" class="form-text text-danger">{{ $message }}</small>
                           @enderror
                        </div>
                     </div>
                  @endcan
                  @can('changeRoles', $user)
                     <div class="form-group">
                        <label for="roles">Roles</label>
                        <select class="form-control @error('roles')border border-danger @enderror" name="roles[]" id="roles" aria-describedby="rolesHelp" multiple>
                           @foreach($roles as $tag)
                           <option value="{{ $tag->id }}" {{ $user->roles->contains('id', $tag->id) ? 'selected' : ''}}>{{ $tag->name}}</option>
                           @endforeach
                        </select>
                        @error('roles')
                        <small id="rolesHelp" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                     </div>
                  @endcan
                  <button type="submit" class="btn btn-primary">Submit</button>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection