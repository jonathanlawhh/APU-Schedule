<h4 id="ondutyContent">HAhahah</h4>
<p>
  <label><input class="with-gap dateDay" name="date" type="radio" value="<?php echo date('l'); ?>" checked /><span>TODAY</span></label>
  <label><input class="with-gap dateDay" name="date" type="radio" value="Monday" /><span>MONDAY</span></label>
  <label><input class="with-gap dateDay" name="date" type="radio" value="Tuesday" /><span>TUESDAY</span></label>
  <label><input class="with-gap dateDay" name="date" type="radio" value="Wednesday" /><span>WEDNESDAY</span></label>
  <label><input class="with-gap dateDay" name="date" type="radio" value="Thursday" /><span>THURSDAY</span></label>
  <label><input class="with-gap dateDay" name="date" type="radio" value="Friday" /><span>FRIDAY</span></label>
</p>
<div class="divider"></div>
<p>
  <label><input class="with-gap duty" name="duty" type="radio" value="rounding" checked/><span>Rounding</span></label>
  <label><input class="with-gap duty" name="duty" type="radio" value="qc" /><span>QC</span></label>
  <label><input class="with-gap duty" name="duty" type="radio" value="apiithelpdesk" /><span>APIIT Helpdesk</span></label>
  <label><input class="with-gap duty" name="duty" type="radio" value="apiitqc" /><span>APIIT Rounding/QC</span></label>
</p>
<div class="row">
  <button onclick="doSearch()" id="btn_all" class="waves-effect waves-light btn col s10 m4 l3" style="margin-left:10px;"><i class="material-icons left">lightbulb_outline</i>Search</button>
</div>

<p id="searchInfo"></p>
<a id='hidemsg2' onclick='hidethead2()' class='hide-on-med-and-up'>Toggle table header</a>
<table class="highlight responsive-table">
  <thead id='removethead2' <?php if(isset($_COOKIE['apuschedule-tablehead'])){ echo "style='display:none;'"; }?>><tr><th>Shift</th><th>Human</th></tr></thead>
  <tbody id="resultArea"></tbody>
</table><div class="marginbottom30"></div>
