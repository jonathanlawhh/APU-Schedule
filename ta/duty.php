<?php $date = $_POST['date'] ?? 'TODAY'; ?>
<h4 id="ondutyContent">HAhahah</h4>
<p>
  <label>
    <input class="with-gap dateDay" name="date" type="radio" id="option-0" value="<?php echo date('l'); ?>" <?php if($date === 'TODAY' || $date === 'Sat' || $date === 'Sun'){?>checked<?php } ?>/>
    <span>TODAY</span>
  </label>
  <label>
    <input class="with-gap dateDay" name="date" type="radio" id="option-1" value="Monday" />
    <span>MONDAY</span>
  </label>
  <label>
    <input class="with-gap dateDay" name="date" type="radio" id="option-2" value="Tuesday" />
    <span>TUESDAY</span>
  </label>
  <label>
    <input class="with-gap dateDay" name="date" type="radio" id="option-3" value="Wednesday" />
    <span>WEDNESDAY</span>
  </label>
  <label>
    <input class="with-gap dateDay" name="date" type="radio" id="option-4" value="Thursday" />
    <span>THURSDAY</span>
  </label>
  <label>
    <input class="with-gap dateDay" name="date" type="radio" id="option-5" value="Friday" />
    <span>FRIDAY</span>
  </label>
</p>
<div class="divider"></div>
<p>
  <label>
    <input class="with-gap duty" name="duty" type="radio" id="duty-0" value="rounding" checked/>
    <span>Rounding</span>
  </label>
  <label>
    <input class="with-gap duty" name="duty" type="radio" id="duty-1" value="qc" />
    <span>QC</span>
  </label>
  <label>
    <input class="with-gap duty" name="duty" type="radio" id="duty-2" value="apiithelpdesk" />
    <span>APIIT Helpdesk</span>
  </label>
  <label>
    <input class="with-gap duty" name="duty" type="radio" id="duty-3" value="apiitqc" />
    <span>APIIT Rounding/QC</span>
  </label>
</p>
<div class="row">
<button onclick="doSearch()" id="btn_all" class="waves-effect waves-light btn col s10 m4 l3" style="margin-left:10px;">
  <i class="material-icons left">lightbulb_outline</i>Search
</button>
</div>

<p id="searchInfo"></p>
<a id='hidemsg2' onclick='hidethead2()' class='hide-on-med-and-up'>Toggle table header</a>
<table class="highlight responsive-table">
  <thead id='removethead2' <?php if(isset($_COOKIE['apuschedule-tablehead'])){ echo "style='display:none;'"; }?>><tr><th>Shift</th><th>Human</th></tr></thead>
  <tbody id="resultArea"></tbody>
</table><div class="marginbottom30"></div>
