<form hidden action="" id="form-delete" method="POST">@csrf @method('DELETE')</form>
<form hidden action="" id="form-file-delete" method="POST">@csrf @method('DELETE')</form>
<form hidden action="" id="form-update-sumber-data" method="POST">@csrf @method('PUT')
  <input type="text" name="sumber_data">
</form>
<form hidden action="" method="POST" id="form-delete-year">@csrf @method('DELETE')</form>
