<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cascading Dropdowns</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <label for="province">Select Province:</label>
    <select id="province">
        <option value="">-- Select Province --</option>
    </select>

    <label for="municipality">Select Municipality:</label>
    <select id="municipality">
        <option value="">-- Select Municipality --</option>
    </select>

    <label for="barangay">Select Barangay:</label>
    <select id="barangay">
        <option value="">-- Select Barangay --</option>
    </select>

    <script src="app.js"></script>
</body>

<script>
    $(document).ready(function () {
        // Fetch provinces when the page loads
        $.ajax({
            url: 'https://psgc.gitlab.io/api/provinces',
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                // Populate the province dropdown
                $.each(data, function (index, province) {
                    $('#province').append($('<option>', {
                        value: province.code,
                        text: province.name
                    }));
                });
            },
            error: function () {
                console.error('Error fetching provinces');
            }
        });

        // When a province is selected, fetch municipalities
        $('#province').change(function () {
            const provinceCode = $(this).val();
            $('#municipality').empty().append('<option value="">-- Select Municipality --</option>');
            $('#barangay').empty().append('<option value="">-- Select Barangay --</option>');

            if (provinceCode) {
                $.ajax({
                    url: `https://psgc.gitlab.io/api/municipalities?province_code=${provinceCode}`,
                    method: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        $.each(data, function (index, municipality) {
                            $('#municipality').append($('<option>', {
                                value: municipality.code,
                                text: municipality.name
                            }));
                        });
                    },
                    error: function () {
                        console.error('Error fetching municipalities');
                    }
                });
            }
        });

        // When a municipality is selected, fetch barangays
        $('#municipality').change(function () {
            const municipalityCode = $(this).val();
            $('#barangay').empty().append('<option value="">-- Select Barangay --</option>');

            if (municipalityCode) {
                $.ajax({
                    url: `https://psgc.gitlab.io/api/barangays?municipality_code=${municipalityCode}`,
                    method: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        $.each(data, function (index, barangay) {
                            $('#barangay').append($('<option>', {
                                value: barangay.code,
                                text: barangay.name
                            }));
                        });
                    },
                    error: function () {
                        console.error('Error fetching barangays');
                    }
                });
            }
        });
    });

</script>

</html>