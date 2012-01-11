<?php
if (isset($current_user)) {
?>
  <div class="row">
  <div class="span10">
  <h2>Recently published content</h2>
  </div>
  <div class="span6" id="about-user">
  <h1 id="stats-header"><?php echo $current_user->name ?> statistics</h1>
  <div id="stats">lorem ipsum dolor sit amet</div>
  <div id="new-content-wrapper">
  <a href="/content/new" class="btn primary" id="new-content">Create new content</a>
  </div>
  </div>
  </div>
<?php
} else {
?>
  <h1>Welcome to Content Menage</h1>
<?php
}
?>