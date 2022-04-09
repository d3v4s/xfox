# XFOX
Bypass CSP script nonce on Mozilla Firefox.

This is a proof of concept of a vulnerability on Mozilla Firefox for desktop and mobile,
which allows you to insert a script despite the CSP policy does not allow it.  
The same problem is also present in safari web browsers.

## Explain it
If a nonce for sources is specified in CSP, then only the sources with
valid nonce are processed by the client.  
When a valid script tries to include a second script, the latter should
be locked unless the 'strict-dynamic' has been set in the CSP, and that's
where the bug is located.  

Suppose we have these CSP:  
`Content-Security-Policy: "default-src 'self'; script-src 'nonce-r4nd0m'; style-src 'nonce-r4nd0m'"`.  
In this way only scripts with the nonce will be considered valid, and if one of them tries to include
a second javascript file, then it must be blocked. But if we recover the nonce from a js element
present in the DOM, we can include a second or more javascript files.  

This is the js code that takes the nonce and creates a valid javascript source:  
```
/* sniff script nonce from DOM */
const scriptNonce = document.getElementsByTagName('script')[0].getAttribute('nonce');
/* init malicious script */
var malScript = document.createElement('script');
/* set and append script */
malScript.src = '/js/evil.js';
malScript.type = "text/javascript";
/* insert sniffed nonce */
malScript.setAttribute('nonce', scriptNonce);
/* append malicious script on body */
document.body.appendChild(malScript);

```

## Proof of concept
You can test it by running a PHP server with the root set in the `src` directory of this project.  
In this test we have a js file that is included using the nonce (`/js/script.js`), and it is inside it that is inserted
the code that takes the valid nonce, and reuses it to insert the malicious javascript (`/js/evil.js`).  
The inclusion of a another js file, from a valid js file, must be possible only if the strict-dynamic
is specified, but to bypass it, is sufficient to recover the nonce from a valid element, and insert it
in the source of evil js to be included.

I tried to insert a css file with the same method, but in this case the file is blocked.
