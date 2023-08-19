//This one used for operation result
//Use sweetalert to show the popup
const urlParams = new URLSearchParams(window.location.search);
const target = urlParams.get('target');
const action = urlParams.get('action');
const isSuccess = urlParams.get('success');

if (isSuccess === '1') {
    Swal.fire(
            'Finish ' + action,
            target + ' ' + action + ' was successful !',
            'success'
            );
} else if (isSuccess === '0') {
    Swal.fire(
            'Oops, ' + action + ' fail!',
            'Unsucessful ' + target + ' ' + action + ' ...',
            'error'
            );
}
