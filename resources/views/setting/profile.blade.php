@extends('layouts.template')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle" src="{{ Auth::user()->profile == null ? 'https://gerbangbelajar.id/assets/dist/user/user.png' : asset('storage/' . Auth::user()->profile) }}" alt="User profile picture">
                    </div>
                    <br>
                    <h3 class="profile-username text-center">
                        {{ Auth::user()->nama }}
                    </h3>

                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="form-horizontal" id="form-avatar">
                        @csrf
                        @method('PUT')
                        <div class="form-message-image text-center"></div>
                        <div class="form-group row mb-1">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="image" name="image" onchange="showDir('#image', '#image-label')" accept="image/*">
                                    <label class="custom-file-label" id="image-label" for="image">Pilih Gambar</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row float-right mb-0">
                            <button type="submit" class="btn btn-primary">Ganti Foto Profil</button>
                        </div>
                    </form>

                    <form method="post" action="{{ route('profile.delete', Auth::user()->user_id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus Foto Profil</button>
                    </form>

                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card card-primary card-outline card-tabs">
                <div class="card-header p-0 pt-1 border-bottom-0">
                    <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                        <li class="nav-item"><a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true">Edit Profile</a></li>
                        <li class="nav-item"><a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill" href="#custom-tabs-three-profile" role="tab" aria-controls="custom-tabs-three-profile" aria-selected="false">Edit Password</a></li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-three-tabContent">
                        <div class="tab-pane fade active show" id="custom-tabs-three-home" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
                            <form method="post" action="https://gerbangbelajar.id/s_profile" role="form" class="form-horizontal" id="form-profile" novalidate="novalidate">
                                <div class="form-message-profile text-center"></div><input type="hidden" name="_token" value="8fqaoLNXm9AZRPon8Qif1c4PlgspFeF6lsvHEtQQ"><input type="hidden" name="_method" value="PUT">
                                <div class="form-group row mb-1"><label for="inputUsername" class="col-sm-2 col-form-label">Username</label>
                                    <div class="col-sm-10"><input disabled="" type="text" class="form-control form-control-sm" value="{{ Auth::user()->username }}"></div>
                                </div>
                                <div class="form-group row mb-1"><label for="" class="col-sm-2 col-form-label">Nama</label>
                                    <div class="col-sm-10"><input disabled="" type="text" class="form-control form-control-sm" value="{{ Auth::user()->nama }}"></div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-three-profile" role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab">
                            <form method="post" action="https://gerbangbelajar.id/s_profile/password" role="form" class="form-horizontal" id="form-password" novalidate="novalidate">
                                <div class="form-message-password text-center"></div><input type="hidden" name="_token" value="8fqaoLNXm9AZRPon8Qif1c4PlgspFeF6lsvHEtQQ"><input type="hidden" name="_method" value="PUT">
                                <div class="form-group row mb-1"><label for="password_old" class="col-sm-3 col-form-label">Password Lama</label>
                                    <div class="col-sm-9"><input type="password" class="form-control form-control-sm" id="password_old" name="password_old" placeholder="Masukan Password Lama"></div>
                                </div>
                                <hr>
                                <div class="form-group row mb-1"><label for="password" class="col-sm-3 col-form-label">Password Baru</label>
                                    <div class="col-sm-9"><input type="password" class="form-control form-control-sm" id="password" name="password" placeholder="Masukan Password Baru"></div>
                                </div>
                                <div class="form-group row mb-1"><label for="password_confirmation" class="col-sm-3 col-form-label">Ulangi Password Baru</label>
                                    <div class="col-sm-9"><input type="password" class="form-control form-control-sm" id="password_confirmation" name="password_confirmation" placeholder="Ulangi Password Baru"></div>
                                </div>
                                <div class="row"><label class="col-sm-3"></label>
                                    <div class="col-sm-9"><button type="submit" class="btn btn-success">Submit</button></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function showDir(inputSelector, labelSelector) {
            const input = document.querySelector(inputSelector);
            const label = document.querySelector(labelSelector);

            if (input.files && input.files.length > 0) {
                label.textContent = input.files[0].name;
            } else {
                label.textContent = 'Pilih file...';
            }
        }
    </script>
@endpush
