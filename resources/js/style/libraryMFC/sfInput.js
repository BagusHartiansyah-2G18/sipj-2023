let _vimg={
    size :15000000 //2 MB
    ,data:Array()
    ,fileName:["jpg","jpeg","png","bmp"]
    ,maxUpload:2
    ,idView:"sImage"
  },
  _vfile={
    size :15000000 //2 MB
    ,data:Array()
    ,fileName:["application/pdf","pdf"]
    ,maxUpload:2
    ,idView:"files"
  };
function _readImage(input) {
    if (input.files && input.files[0]) {
        let reader = new FileReader();
        new Promise(function(res){
            let img = new Image;
            reader.readAsDataURL(input.files[0]);
            reader.onload = function (e) {
                img.src = reader.result;
                res({
                    src :img.src,
                    nama:input.files.item(0).name,
                    size:input.files.item(0).size,
                    type:input.files.item(0).type
                });
            }
        }).then(resp=>{
            
            // console.log("Bagus H");
            if(resp.size<=_vimg.size){
                nama=resp.nama.split(".");
                let checked=false;
                _vimg.fileName.forEach(v => {
                    if(nama[1].toUpperCase()==v.toUpperCase()){
                        checked=true;
                    }
                });
                if(checked){
                    if(_vimg.data.length+1<=_vimg.maxUpload){
                        _vimg.data.push(resp);
                        // console.log(_getImage());
                        $('#'+_vimg.idView).html(_getImage());
                    }else{
                        return _toast({bg:'e', msg:"cukup "+_vimg.maxUpload+" file photo saja !!!"});
                    }
                }else{
                    let ket="";
                    _vimg.fileName.forEach(v => {
                        ket+=v+" ";
                    });
                    _toast({bg:'e', msg:"Format File Harus "+ket+" !!!"});
                }
            }else{
                _toast({bg:'e', msg:"Ukuran File Maksimal "+(_vimg.size/1000000)+" MB !!!"});
            }
        })
    }
}
function _getImage(){
    let tam=`
    <div class="table-border-style">
      <div class="table-responsive">
        <table class="table" id="dataTabel">
        <thead>
            <tr>
            <th>no</th>
            <th>Nama</th>
            <th colspan="2" style="text-align:center;">Action</th>
            </tr>
            </thead>
            <tbody>
    `;
    for(let a=0;a<_vimg.data.length;a++){
      tam+=`
      <tr>
          <td>`+(a+1)+`</td>
          <td>`+_vimg.data[a].nama+`</td>
          <td class="text-center">`+
            _btnTabel([{ 
                clsBtn:`btn-outline-warning`
                ,func:`_viewImage(`+a+`)`
                ,icon:`<i class="mdi mdi-eye"></i>`
                ,title:"Lihat Gambar"
            },
            { 
                clsBtn:`btn-outline-danger`
                ,func:`_deleteImage(`+a+`)`
                ,icon:`<i class="mdi mdi-delete-forever"></i>`
                ,title:"Delete"
            }])
          +`
          </td>
      </tr>
      `;
    }
    tam+=`
          </tbody>
          </table>
      </div>
      </div>
    `;
    return tam;
}
function _viewImage(ind){
  return  window.open(_vimg.data[ind].src,'Image');
}
function _deleteImage(ind){
    _vimg.data.splice(ind,1);
  $('#'+_vimg.idView).html(_getImage());


}
function _resetImg(){
    _vimg.data=[];
    $('#images').html('');
}