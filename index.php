<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Info Pelanggan</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>
    html, body { max-width: 100%; overflow-x: hidden; padding: 20px; }
    .btn-xlarge { padding: 8px 28px; font-size: 22px; border-radius: 8px; }
    .ukur-section input { margin: 4px 0; }
    #secondukurerror, #persenukurerror { font-family: Courier New; font-size: 30px; }
  </style>
</head>
<body>

<!-- Ukur Section -->
<div class="ukur-section">
  <h4>Ukur Error kWH Meter</h4>
  <p class="text-muted">by Agus Haryadi</p>

  <div class="row mb-3">
    <div class="col-md-2">
      <label class="form-label">CosΦ (cos phi)</label>
      <input id="cospiukurerror" type="number" step="0.01" class="form-control" value="0.85" placeholder="Misal: 0.85">
    </div>
    <div class="col-md-2">
      <label class="form-label">N (putaran)</label>
      <input id="nukurerror" type="number" class="form-control" value="5" placeholder="Misal: 5">
    </div>
    <div class="col-md-2">
      <label class="form-label">V (Volt)</label>
      <input id="tegukurerror" type="number" class="form-control" value="220" placeholder="Misal: 220">
    </div>
    <div class="col-md-3">
      <label class="form-label">Kons (konstanta)</label>
      <input id="konsukurerror" type="number" class="form-control" placeholder="Misal: 800">
    </div>
    <div class="col-md-3">
      <label class="form-label">Arus (I) [Ampere]</label>
      <input id="arusukurerror" type="number" class="form-control" placeholder="Misal: 5">
    </div>
  </div>

  <div class="row align-items-center mb-4 justify-content-center text-center" style="font-size: 30px; font-family: 'Courier New', monospace;">
  <div class="col-auto">
    <span id="secondukurerror">0.0</span><span class="ms-1"></span>
  </div>
  <div class="col-auto">
    <button id="buttonstarttimer" class="btn btn-success btn-lg mx-2" onclick="starttimer()">Start</button>
    <button id="buttonstoptimer" class="btn btn-danger btn-lg mx-2" onclick="stoptimer()" style="display:none;">Stop</button>
  </div>
  <div class="col-auto">
    <span id="persenukurerror">–</span><span class="ms-1"></span>
  </div>
</div>


  <input type="hidden" id="xerrkwh" />
</div>


<script src="js/jquery-3.3.1.min.js"></script>
<script>
  let startTime, interval, errorkwh;

  function starttimer() {
    $('#buttonstarttimer').hide();
    $('#buttonstoptimer').show();
    startTime = Date.now();
    interval = setInterval(() => {
      const detik = ((Date.now() - startTime) / 1000).toFixed(1);
      $('#secondukurerror').text(`${detik} s`);
    }, 100);
  }

  function stoptimer() {
    clearInterval(interval);
    $('#buttonstoptimer').hide();
    $('#buttonstarttimer').show();

    const N = +$('#nukurerror').val();
    const cosphi = +$('#cospiukurerror').val();
    const V = +$('#tegukurerror').val();
    const kons = +$('#konsukurerror').val();
    const arus = +$('#arusukurerror').val();
    const t = (Date.now() - startTime) / 1000;

    errorkwh = (((N * 3600 * 1000) / (V * arus * cosphi * kons) - t) / t * 100).toFixed(2);
    $('#persenukurerror').text(`${errorkwh} %`);
  }

  function gunakanhasil() {
    $('#xerrkwh').val(errorkwh);
    alert("Hasil error kWh disimpan: " + errorkwh + "%");
  }
</script>
</body>
</html>