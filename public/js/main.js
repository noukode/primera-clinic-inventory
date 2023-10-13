const token = document.querySelector('meta[name=csrf-token]').getAttribute('content');
const Helper = {
    refresh: function(){
        location.reload();
    },
    simpleNotification: function(title, msg, icon){
        return Swal.fire({
            title: title,
            text: msg,
            icon: icon
        });
    },
    confirmAlert: function(msg, icon, confirmText){
        return Swal.fire({
            title: msg,
            text: "You won't be able to revert this!",
            icon: icon,
            showCancelButton: true,
            confirmButtonText: confirmText
        }).then(result => result);
    },
    fetchDelete: function(url, data = {}){
        let formData = new FormData;

        formData.append('_method', 'DELETE');
        return fetch(url, {
            method: 'POST',
            headers:{
                'X-CSRF-TOKEN':token,
            },
            body: formData
        })
    }
}
