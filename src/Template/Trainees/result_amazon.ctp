<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

</body>

<script type="text/javascript">
	function getParameterByName(name) {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
            results = regex.exec(location.search);
        return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    }

    var resultCode = getParameterByName('resultCode');
    var failureCode = getParameterByName('failureCode');
    var urlParams = '?'+ window.location.search.substring(1);
    var successUrl = "";

    if (resultCode === 'Success') {
        var successUrl = '<?php echo $this->request->webroot; ?>trainees/success';
        window.location.href = successUrl + urlParams;
    }

</script>

</html>