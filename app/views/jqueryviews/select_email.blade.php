
<div id="send_email" class="send_email">
    <label>Email</label>
    <div class="input-group" id="email" style="width: 80%">
        <input autocomplete="off" class="form-control" type="text" name="email" value="<?php echo $user['email']; ?>" readonly>
        <input type="hidden" name="name" value="<?php echo $user['first_name']; ?>">
    </div>
</div>