<!DOCTYPE html>
<html>
<head>
    <title>Student Management | Add</title>
</head>
<body>
@if (session('status'))
    <div class="alert alert-success" role="alert">
        <button type="button" class="close" data-dismiss="alert">×</button>
        {{ session('status') }}
    </div>
@elseif(session('failed'))
    <div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert">×</button>
        {{ session('failed') }}
    </div>
@endif
<form action = "/create" method = "post">
    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
    <table>
        <td>User(必須)</td>
        </tr>
            <td><input type="text" name='user'/>
            </td>
        </tr>
        <tr>
        <td>UserName(必須)</td>
        </tr>
        <td><input type="text" name='user_name'/></td>
        </tr>
        <tr>
            <td>Email(必須)</td>
        </tr>
            <td><input type="text" name='email'/></td>
        </tr>
        <tr>
            <td>Address</td>
        </tr>
            <td><input type="text" name='address'/></td>
        </tr>

        <tr>
            <td colspan = '1'>
                <input type = 'submit' value = "Save"/>
                <input type = 'submit' value = "Cancel"/>

            </td>
        </tr>
    </table>
</form>
</body>
</html>
