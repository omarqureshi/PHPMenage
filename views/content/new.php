<?php if (isset($klass)) {

var_dump($klass->attributes());

} else {
?>
<form action="/content/new" method="GET">
  <fieldset>
   <legend class="hide">Pick a content type</legend>
   <div class="clearfix">
   <label>Pick a content type</label>
   <div class="input">
   <select name="content_type">
<?php foreach(Content::children() as $type) {
?>
<option value="<?php echo $type; ?>"><?php echo $type; ?></option>
<?php
}

?>
   </select>
</div>
<div class="actions">
   <input type="submit" class="btn primary" value="Pick content type" />
</div>
  </div>
</form>

<?php } ?>