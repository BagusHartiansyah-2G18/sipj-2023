let _vtabel={
    length:25,
    title:'Laporan_'
};
function btabel(v){
    // datax=[];
    // datax.push({
    //     valueName:"Dinas",
    //     value:"Bappeda"
    // });
    // datax.push({
    //     valueName:"Usulan",
    //     value:"Pembahasan"
    // });
    // return _tabelResponsive(
    //     {
    //         id:"dataTabel"
    //         ,isi:_tabel(
    //             {
    //                 data:datax
    //                 ,no:1
    //                 ,kolom:[
    //                     "value","valueName"
    //                 ]
    //                 ,namaKolom:[
    //                     "Nama","Keterangan"
    //                 ]
    //             })
    //     });
    fdata="table-striped table-bordered";
    if(v.class!=undefined){
        fdata=v.class;
    }
    fattr="";
    if(v.attr!=undefined){
        fattr=v.attr;
    }
    return `
    <div class="bootstrap-data-table-panel">
        <div class="table-responsive" `+fattr+`>
            <table id="`+v.id+`" class="table `+fdata+`" style="width:100%">
                `+v.isi+`
            </table>
        </div>
    </div>
    `;
} 
function _tabel(v){
    // _tabel(
    // {
    //     data:_.dusulan
    //     ,no:1
    //     ,kolom:[
    //         "nmDinas","nmUsulan","checkbox"
    //     ]
    //     ,namaKolom:[
    //         "Nama Dinas","Usulan","Action"
    //     ]
    // })
    var fdata=`
    <thead>
        <tr>`,fno=false,faction=false;
    
    if(v.no>0){
        fdata+=`<th>no</th>`;
        fno=true;
    }else{
        v.no=1;
    }
    v.namaKolom.forEach(v1 => {
        fdata+=`<th>`+v1+`</th>`;
    });
    if(v.action!=null || v.action!=undefined){
        fdata+=`<th>Action</th>`;
        faction=true;
        if(v.action.length==0){
            v.action.push({ 
                clsBtn:`btn-outline-danger`
                ,icon:`<i class="mdi mdi-lock"></i>`
                ,title:"TERKUNCI"
            });
        }
    }
    fdata+=`</tr>
        </thead>
        <tbody>`;
    v.data.forEach((v1,i1) => {
        fdata+=`
            <tr>`;
            if(fno){
                fdata+=`<td>`+v.no+`</td>`;
            }
            v.no+=1;
        v.kolom.forEach((v2,i2) => {
            // f1data=v2.split("$");
            // if(f1data.length==2){
            //     fdata+=`<td>`+_$(v1[f1data[0]])+`</td>`;
            // }else{
            //     if(v2=="checkbox"){
            //         if(v.func!=undefined){
            //             fdata+=`<td>`+_inp({type:"checkbox", attr:" onchange='"+v.func.substring(0,v.func.length-1)+i1+",this)' "+_trueChecked(1,Number(v1['value']))})+`</td>`;
            //         }else{
            //             fdata+=`<td>`+_inp({type:"checkbox"})+`</td>`;
            //         }
            //     }else{
            //         fdata+=`<td>`+v1[v2]+`</td>`;
            //     }
            // }
            kond=true;
            f1data=v2.split("$");
            if(f1data.length==2){
                fdata+=`<td>`+_$(v1[f1data[0]])+`</td>`;
                kond=false;
            }
            if(v2=="checkbox" && kond){
                // console.log(v1['checked']);
                if(v.func!=undefined){
                    kond=false;
                    fdata+=`<td>`+_inp({type:"checkbox", attr:" onchange='"+v.func.substring(0,v.func.length-1)+i1+",this)'",checked:_trueChecked(1,Number(v1['checked']))  })+`</td>`;
                }else{
                    
                    kond=false;
                    fdata+=`<td>`+_inp({type:"checkbox" ,attr:"", checked:_trueChecked(1,Number(v1['checked']))})+`</td>`;
                }
            }
            f1data=v2.split("+");
            if(f1data.length==2){
                fdata+=`<td>`+_$(
                    Number(v1[f1data[0]])+Number(v1[f1data[1]])
                    )+`</td>`;
                kond=false;
            }
            f1data=v2.split("-");
            if(f1data.length==2){
                fdata+=`<td>`+_$(
                    Number(v1[f1data[0]])-Number(v1[f1data[1]])
                )+`</td>`;
                kond=false;
            }
            f1data=v2.split("*");
            if(f1data.length==2){
                fdata+=`<td>`+_$(
                    Number(v1[f1data[0]])*Number(v1[f1data[1]])
                )+`</td>`;
                kond=false;
            }
            f1data=v2.split("/");
            if(f1data.length==2){
                fdata+=`<td>`+_$(
                    Number(v1[f1data[0]])/Number(v1[f1data[1]])
                )+`</td>`;
                kond=false;
            }
            if(kond){
                fdata+=`<td>`+v1[v2]+`</td>`;
            }
        });
        if(faction){
            fdata+=`<td style="min-width: 15%;justify-content: center;display: flex;">`+_btnTabel(v.action,v.no-2)+`</td>`;
        }
        fdata+=`</tr>`;
        if(v.subKolom!=undefined && v.subKolom.length>0){
            fdata+=`
            <tr id="`+v.subKolom[0]+(v.no-2)+`" style="display: none;">`;
                if(fno){
                    fdata+=`<td>`+(v.no-1)+`</td>`;
                }
            v.kolom.forEach((v3,i3) => {
                fdata+=`<td>`+v1[v3]+`</td>`;
            })
            if(faction){
                fdata+=`<td style="min-width: 15%;justify-content: center;display: flex;">`+_btnTabel(v.action,v.no-2)+`</td>`;
            }
            fdata+=`</tr>`;
        }
        
    });

   return fdata+=`</tbody>`;
}
function btabelForExcel(v){
    var fdata=`
    <thead>
        <tr>`,fno=false,faction=false;
    
    if(v.no>0){
        fdata+=`<th>no</th>`;
        fno=true;
    }
    v.namaKolom.forEach(v1 => {
        fdata+=`<th>`+v1+`</th>`;
    });
    if(v.action!=null || v.action!=undefined){
        fdata+=`<th>Action</th>`;
        faction=true;
        if(v.action.length==0){
            v.action.push({ 
                clsBtn:`btn-outline-danger`
                ,icon:`<i class="mdi mdi-lock"></i>`
                ,title:"TERKUNCI"
            });
        }
    }
    fdata+=`</tr>
        </thead>
        <tbody>`;
    v.data.splice(0,1);
    v.data.forEach((v1,i1) => {
        fdata+=`
            <tr>`;
            if(fno){
                fdata+=`<td>`+v.no+`</td>`;
                v.no+=1;
            }
        v.kolom.forEach((v2,i2) => {
            try {
                f1data=v2.split("$");
                if(f1data.length==2){
                    fdata+=`<td>`+_$(v1[Number(f1data[0])])+`</td>`;
                }else{
                    if(v2=="checkbox"){
                        if(v.func!=undefined){
                            fdata+=`<td>`+_inp({type:"checkbox", attr:" onchange='"+v.func.substring(0,v.func.length-1)+i1+",this)' "})+`</td>`;
                        }else{
                            fdata+=`<td>`+_inp({type:"checkbox"})+`</td>`;
                        }
                    }else{
                        fdata+=`<td>`+v1[v2]+`</td>`;
                    }
                }
            } catch (error) {
                if(v1[v2]!=null){
                    fdata+=`<td>`+v1[v2]+`</td>`;
                }else{
                    fdata+=`<td></td>`;
                }
            }
        });
        if(faction){
            fdata+=`<td>`+_btnTabel(v.action,v.no-2)+`</td>`;
        }
        fdata+=`</tr>`;
    });

   return fdata+=`</tbody>`;
}
function _readExcell(id){
    // var input = document.getElementById(id)
    return new Promise(function(res){
        readXlsxFile(id.files[0], { dateFormat: 'MM/DD/YY' }).then(function(data) {
                res({
                    exec:true,
                    data:JSON.parse(JSON.stringify(data, null, 2))
                })},
            function (error) {
                res({
                    exec:false,
                    msg:error
                });
            }
        )
    })
}
function _btabelStart(id,all){
    $(document).ready(function() {
        if(all==undefined){
            return $('#'+id).DataTable({
                "pageLength": _vtabel.length
            }); 
        }else if(all){
            return $('#'+id).DataTable({
                // buttons: true
                // dom: 'Bfrtip',
                pageLength: _vtabel.length,
                dom: 'Blfrtip',
                lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"]],
                buttons: [
                    { extend: 'pdf', className: 'btn btn-success buttons-copy buttons-html5',title:_vtabel.title},
                    { extend: 'excel', className: 'btn btn-primary buttons-copy buttons-html5 mr-3',title:_vtabel.title}
                    // 'copy', 'csv', 'excel', 'pdf', 'print'
                ],
            });
        }else{
            return $('#'+id).DataTable({
                // buttons: true
                // dom: 'Bfrtip',
                pageLength: _vtabel.length,
                dom: 'Blfrtip',
                lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"]],
                buttons: [
                    { extend: 'copy', className: 'btn btn-secondary buttons-copy buttons-html5' ,title:_vtabel.title},
                    { extend: 'csv', className: 'btn btn-warning buttons-copy buttons-html5' ,title:_vtabel.title},
                    { extend: 'excel', className: 'btn btn-outline-primary bg-primary text-dark buttons-copy buttons-html5' ,title:_vtabel.title},
                    { extend: 'pdf', className: 'btn btn-success buttons-copy buttons-html5' ,title:_vtabel.title},
                    { extend: 'print', className: 'btn btn-info buttons-copy buttons-html5 mr-3',title:_vtabel.title }
                    // 'copy', 'csv', 'excel', 'pdf', 'print'
                ],
            });
        }
    });


    // $(document).ready(function() {
    //     // $('#'+id).DataTable();
        
        // $('#'+id).DataTable({
        //     // buttons: true
        //     // dom: 'Bfrtip',
        //     dom: 'Blfrtip',
        //     lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"]],
        //     buttons: [
        //         { extend: 'pdf', className: 'btn btn-success buttons-copy buttons-html5' },
        //         { extend: 'excel', className: 'btn btn-primary buttons-copy buttons-html5 mr-3' }
        //         // 'copy', 'csv', 'excel', 'pdf', 'print'
        //     ],
            
        // });
    // });
}

function _btnTabel(v,id){
    // infoSupport=[];
    // infoSupport.push({ 
    //     clsBtn:`btn-secondary shadow btn-block fzMfc`
    //     ,func:"onOffForm(this)"
    //     ,icon:`<i class="mdi mdi-file-lock  "></i>Form Pekerjaan`
    //     ,title:"Form Pekerjaan"
    // });
    // _btnTabel(infoSupport1,i)
    fdata=``;
    v.forEach((v1,i) => {
        fdata1=v1.func;
        if(id!=undefined){
            try {
                fdata1=v1.func.substring(0,v1.func.length-1)+id+`)`;
            } catch (error) {
                fdata1='';
            }
        }
        ftam="";
        if(v1.title!=null){
            ftam="title='"+v1.title+"'";
        }
        fdata+=`<button type="button" id="bt`+i+``+id+`" class="btn btn-sm `+v1.clsBtn+`" onclick="`+fdata1+`" `+ftam+`>`+v1.icon+`</button>`;
    });
    return `
        <div class="btn-group mr-2">
            `+fdata+`
        </div>
    `;
}