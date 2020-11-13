# ddb-cicero-lms-print-templates
Templates for sending Cicero LMS messages i JSON to REST service via gateway [CPX0196]

<fieldset>
    <legend>&#x26A0; Warning!</legend>
    <p>These templates are in an <i>alpha</i> stage. Do <b>not</b> use them in production!</p>
</fieldset>

Specific messages are converted into JSON structures for [Freemarker](http://freemarker.org/docs/dgui.html) templates for Cicero

These templates are to be included in FBS.

```
├── buildTemplates.sh         Build script
├── Data
│   ├── Clips from documentation
│   :
│   └── ..
├── README.md
├── reservationsnote.template Example
├── template.php              Conversion script              
├── template.txt              Example
└── Templates
    ├── Build templates
    └── ..
```
