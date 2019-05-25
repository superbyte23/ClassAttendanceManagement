<?php require 'include/header.php'; ?>
<body>
<div class="jquery-script-clear"></div>
</div>
</div>
  <div class="container">
    <h1>Simple Table Cell Editor Demo</h1>
    <table id="myTableId" class="table table-dark table-striped table-sm">
  <tr>
    <th>Company</th>
    <th>Contact</th>
    <th>Country</th>
  </tr>
  <tr>
    <td class="editMe">Alfreds Futterkiste</td>
    <td class="editMe">Maria Anders</td>
    <td class="editMe">Germany</td>
  </tr>
  <tr>
    <td class="editMe">Centro comercial Moctezuma</td>
    <td class="editMe">Francisco Chang</td>
    <td class="editMe">Mexico</td>
  </tr>
  <tr>
    <td class="editMe">Ernst Handel</td>
    <td class="editMe">Roland Mendel</td>
    <td>Austria</td>
  </tr>
  <tr>
    <td class="editMe">Island Trading</td>
    <td class="editMe">Helen Bennett</td>
    <td class="editMe">UK</td>
  </tr>
  <tr>
    <td class="editMe">Laughing Bacchus Winecellars</td>
    <td class="editMe">Yoshi Tannamuri</td>
    <td class="editMe">Canada</td>
  </tr>
  <tr>
    <td class="editMe">Magazzini Alimentari Riuniti</td>
    <td class="editMe">Giovanni Rovelli</td>
    <td class="editMe">Italy</td>
  </tr>
</table>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="assets/plugins/SimpleTableCellEditor/SimpleTableCellEditor.js"></script>
<script>
  $(document).ready(function() {

  editor = new SimpleTableCellEditor("myTableId");
  editor.SetEditableClass("editMe");

  $('#myTableId').on("cell:edited", function (event) {
    console.log(`'${event.oldValue}' changed to '${event.newValue}'`);
  });

});

</script>
</body> 
</html>
