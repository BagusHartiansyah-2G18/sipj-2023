// support acttion ini digunakan untuk aktion yang umum di java script 
function _redirect(url){
    window.location.href = _router+url;
}
function _redirectOpen(url){
    // param={
    //     kdPekerjaan :_.ddata[ind].kdPekerjaan,
    //     kdProduk    :_.ddata[ind].kdProduk,
    //     kdSub       :_.ddata[ind].kdSub,
    // }
    // _redirectOpen("control/subPekerjaan/"+btoa(JSON.stringify(param)));
    window.open(_router+url, '_blank');
}
function _reload(){
   return location.reload();
}
async function _post(url,data){
    _swal({
        type:'loading',
        title:'Loading',
        text:'Mohon Menunggu...'
    });
    return new Promise(function(res){
        data._token  = $("meta[name='csrf-token']").attr("content");
        $.ajax({
            type:'post',
            url:_router+url,
            data,
            // data:{
            //     data,
            //         // data:btoa(JSON.stringify(data)),
            //         // code:btoa(_myCode)
            //     _token  :$("meta[name='csrf-token']").attr("content")
            //     },
            success:function(respon)
            {
                swal.clickCancel();
                res(respon);
            },
            error:function(){
                swal.clickCancel();
                _toast({
                    bg:'e',
                    msg:'Proses bermasalah  !!!'
                })
            },
            timeOut:10000 // 10 detik
        })
    })
}
async function _postNoLoad(url,data){
    return new Promise(function(res){
        $.ajax({
            type:'post',
            url:_router+url,
            data:{
                    data:btoa(JSON.stringify(data)),
                    code:btoa(_myCode)
                },
            success:function(respon)
            {
                res(respon);
            }
        })
    })
}
async function _postFile(url,data,img){
    if(img.length==0){
        img="";
    }
    _swal({
        type:'loading',
        title:'Loading',
        text:'Mohon Menunggu...'
    });
    return new Promise(function(res){
        $.ajax({
            type:'post',
            url:_router+url,
            data:{
                    data:btoa(JSON.stringify(data)),
                    file:img,
                    code:btoa(_myCode)
                },
            success:function(respon)
            {
                swal.clickCancel();
                res(respon);
            },
            error:function(){
                swal.clickCancel();
                _toast({
                        bg:'e',
                        msg:'Proses bermasalah !!!'
                    })
            },
            timeOut:20000 // 20 detik
        })
    })
}
