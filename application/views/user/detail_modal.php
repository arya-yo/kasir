<div class="row">
    <div class="col-12">
        <h6 class="text-muted">Username</h6>
        <p><strong><?php echo $user->Username; ?></strong></p>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <h6 class="text-muted">Role</h6>
        <p>
            <span class="badge <?php echo $user->Role == 'admin' ? 'bg-danger' : 'bg-success'; ?>">
                <?php echo ucfirst($user->Role); ?>
            </span>
        </p>
    </div>
</div>
