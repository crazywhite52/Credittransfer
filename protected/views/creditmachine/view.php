<script>
	$(document).ready(function () {


    $("#ref").click(function(){
      setTimeout(function(){ 
        $("#jqxgrid").jqxGrid('refresh');
      }, 1500);
      
    });


    var getAdapter=function(){
     var source =
     {
      datatype: "json",
      datafields: [
      { name: 'jobno',type: 'string' },
      { name: 'branchname',type: 'string' },
      { name: 'bankname',type: 'string' },
      { name: 'tidcode',type: 'string' },
      { name: 'generation',type: 'string' },
      { name: 'brand',type: 'string' },
      { name: 'vender',type: 'string' },
      { name: 'serial',type: 'string' },
      { name: 'user',type: 'string' },



      ],
      url: '<?php echo $this->createUrl("/creditmachine/show");?>',


      cache: false,


    };

    var dataAdapter = new $.jqx.dataAdapter(source,{
      formatData: function (data) {

       return data;
     }
   });

    return dataAdapter;
  };




            ///////////////////////////////////// initialize jqxGrid/////////////////////
            $("#jqxgrid").jqxGrid(
            {
            source: getAdapter(),
            theme: 'darkblue',
            width: '100%',
            height: '100%',
            filterable: true,
            showfilterrow: true,
            editable:true,
            columnsresize: true,
            pagesize: 20,
            pagesizeoptions: ['20', '50', '100'],
            pageable: true,
            columns: [
             { text: 'หมายเลขTID',datafield: 'tidcode',align: 'center',cellsalign: 'center',width:'8%'},
             { text: 'เลขJob',datafield: 'jobno',cellsalign: 'center',align: 'center',editable:false,hidden: true},
             { text: 'สาขา',datafield: 'branchname',align: 'center',cellsalign: 'left', width:'17%'},
             { text: 'ธนาคาร',datafield: 'bankname',align: 'center',cellsalign: 'left',width: '11%'},
             { text: 'ยี่ห้อเครื่อง',datafield: 'brand',align: 'center',cellsalign: 'center',  width:'8%'},
             { text: 'รุ่นเครื่อง',datafield: 'generation',align: 'center',cellsalign: 'center',width: '8%'},
             { text: 'Serial',datafield: 'serial',align: 'center',cellsalign: 'left',width: '15%'},
             { text: 'Vender',datafield: 'vender',align: 'center',cellsalign: 'center',width:'10%'},
             { text: 'User',datafield: 'user',align: 'center',cellsalign: 'left',width: '12%'},
             { text: '',editable:false, align: 'center' ,columntype: 'button',width: '5%',filterable: false, cellsrenderer: function () {
              return "แก้ไข";
            }, buttonclick: function (row) {
              var datarow = $("#jqxgrid").jqxGrid('getrowdata', row);
              var jobno= datarow.jobno
              $.post('<?php echo $this->createUrl("creditmachine/edit") ?>', {jobno: jobno}, function (data) {
              });
              window.open("/Credittransfer/index.php/creditmachine/editjob?jobno="+datarow.jobno,"_blank","toolbar,scrollbars,resizable,top=0,left=0,width=800px,height=600px");
            }
          },
          { text: '',editable: true, align: 'center' ,columntype: 'button',width: '6%' ,filterable: false , cellsrenderer: function () {
           return "ลบข้อมูล";
         }, buttonclick: function (row) {
           var conf=confirm('คุณต้องการลบข้อมูลนี้ใช่หรือไม่');
           var datarow = $("#jqxgrid").jqxGrid('getrowdata', row);
           var rows={};
           rows['jobno']=datarow.jobno;

                      // alert(pr_id.USER_PR);
                      $.post('<?php echo $this->createUrl("/creditmachine/Delete"); ?>',$.param(rows), function(data, textStatus, xhr) {
                      	$("#jqxgrid").jqxGrid({ source: getAdapter() });
                      });

                    }
                  }



                  ]
                });


$("#export").on("click",function(){

   
      
      var url='<?php echo $this->createUrl("/creditmachine/exportexcel"); ?>';

      window.location.href=url;



    });
          });

        </script>
        <style type="text/css">
        body
        {
          height: 100%;
          width: 100%;
          margin: 0px;
          padding: 0px;
          overflow: hidden;
        }
      </style>
      <head>

       <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


       <!-- <msdropdown> -->
        <link rel="stylesheet" type="text/css" href="../../../Credittransfer/dropdown-master/css/msdropdown/dd.css" />
        <script src="../../../Credittransfer/dropdown-master/js/msdropdown/jquery.dd.js"></script>
        <!-- </msdropdown> -->


      </head>

      <!-- Content Wrapper. Contains page content -->
      <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
      <!-- Content Header (Page header) -->
      <div class="content-wrapper" style="background-color: #d2d0d0;">
       <section class="content-header">
        <h1>
         รายการบันทึกข้อมูลเครื่องรูดบัตรเครดิต

       </h1>
       <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active"> รายการบันทึกข้อมูลเครื่องรูดบัตรเครดิต</li>
       </ol>

     </section>

     <!-- Main content -->
     <section class="content">
      <div class="row">
        <div class="col-md-1">
            
            <button type="button" id="export" class="btn btn-block btn-warning"></i> EXCEL</button>
            </div>
       <div class="col-md-12">


        <div class="box box-info">

         <!-- /.box-header -->
         <!-- form start -->


         <div class="box-body">
          <!--  <<<<->>>> -->
           
           <div id="jqxgrid"></div>
         </div>





         <!--  <<<<->>>> -->
       </div>

       <!-- /.box-body -->

       <!-- /.box-footer -->


     </div>


   </div>
 </div>
</section>
</div>
<style type="text/css" media="screen">
.color1, .jqx-widget .color1 {
  color: #FFFFFF;
  background-color: #00CC00;
}
.color2, .jqx-widget .color2 {
  color: #FFFFFF;
  background-color: red;
}
</style>