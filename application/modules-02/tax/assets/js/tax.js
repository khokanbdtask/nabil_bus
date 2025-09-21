

/*TAX SETTING*/
    // "use strict";
    function add_columnTaxsettings(sl){
        var text = "";
        var i;
        for (i = 0; i < sl; i++) {
            var f = i+1;
          text += '<div class="form-group row"><label for="fieldname" class="col-sm-1 col-form-label">Tax Name' + f + '*</label><div class="col-sm-2"><input type="text" placeholder="Tax Name" class="form-control" required autocomplete="off" name="taxfield[]"></div><label for="default_value" class="col-sm-1 col-form-label">Default Value<i class="text-danger">(%)</i></label><div class="col-sm-2"><input type="text" class="form-control" name="default_value[]" id="default_value"  placeholder="Default Value" /></div><label for="reg_no" class="col-sm-1 col-form-label">Reg No</label><div class="col-sm-2"><input type="text" class="form-control" name="reg_no[]" id="reg_no"  placeholder="Reg No" /></div><div class="col-sm-1"><input type="checkbox" name="is_show" class="form-control" value="1"></div><label for="isshow" class="col-sm-1 col-form-label">Is Show</label></div>';
        }
        document.getElementById("taxfield").innerHTML = text;

    }


    // "use strict";
    function deleteTaxRow(row)
    {
        var i=row.parentNode.parentNode.rowIndex;
        document.getElementById('POITable').deleteRow(i);
    }


    // "use strict";
    function TaxinsRow()
    {
        console.log( 'hi');
        var x=document.getElementById('POITable');
        var new_row = x.rows[1].cloneNode(true);
        var len = x.rows.length;
        new_row.cells[0].innerHTML = len;
        
        var inp1 = new_row.cells[1].getElementsByTagName('input')[0];
        inp1.id += len;
        inp1.value = '';
        var inp2 = new_row.cells[2].getElementsByTagName('input')[0];
        inp2.id += len;
        inp2.value = '';
        x.appendChild( new_row );
    }

    $(document ).ready(function() {
        var taxn =  $("#taxnumber").val();
       for(var i=0;i<taxn;i++){
      
        var sum =0;
        $('.rpttax'+i).each(function()
        {
            sum += parseFloat($(this).text());
        });

        $("#rpttax"+i).html(sum.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2}));
                     
    }
    });
