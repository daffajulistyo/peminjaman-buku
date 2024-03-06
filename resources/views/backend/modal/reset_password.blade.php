 <!-- Modal Reset Password -->
 <div class="modal fade" id="resetPasswordModal{{ $user->id }}" tabindex="-1"
    role="dialog" aria-labelledby="resetPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resetPasswordModalLabel">Reset Password
                    untuk
                    {{ $user->name }}</h5>
                <button type="button" class="close" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form Reset Password -->
                <form action="{{ route('user.resetpassword', ['id' => $user->id]) }}"
                    method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="new_password">Password Baru</label>
                        <input type="password" class="form-control" id="password"
                            name="password" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Reset
                        Password</button>
                </form>
                <!-- End Form Reset Password -->
            </div>
        </div>
    </div>
</div>