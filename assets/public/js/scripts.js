// click and copy ip btn
let ipBtn = $('.ip-btn');

ipBtn.tooltip({
    animated: 'fade',
    placement: 'bottom',
    trigger: 'click'
});

ipBtn.on('click', () => {
    let ip = ipBtn.attr('data-ip');
    let dummy = document.createElement("textarea");

    document.body.appendChild(dummy);

    dummy.value = ip;
    dummy.select();

    document.execCommand('copy');
    document.body.removeChild(dummy);

    setTimeout(() => {
        ipBtn.tooltip('hide');
    }, 2000);
});