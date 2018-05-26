
<div class="container">
    <div class="row">
        
        <div class="col-12">
        <table class="table">
            <thead class="thead-dark">
                <tr>
                <th scope="col">#</th>
                <th scope="col">Trend %</th>
                <th scope="col">Total Quantity</th>
                <th scope="col">Total Value (in Lakhs)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    setlocale(LC_MONETARY,"en_US");
                    foreach($result as $row){
                        ?>
                            <tr>
                                <th scope="row"><?php echo $row['symbol'] ?></th>
                                <td><?php echo $row['trend'] ?></td>
                                <td><?php echo $row['tqty'] ?></td>
                                <td><?php echo money_format('%!i',($row['tval']/IN_LAKH)); ?> L</td>
                            </tr>
                        <?php
                    }
                ?>
            </tbody>
            </table>
        </div>
        
    </div>
</div>

<script src="https://unpkg.com/vue"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
<script>const base_url = "<?=base_url()?>";</script>
</body>
</html>