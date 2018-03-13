<div id="send_city" class="send_city">
    <label>Select City</label>
    <div class="input-group" id="city" style="width: 80%">
        <select name="city" id="users-city" class="form-control">
            <option value="all">All Cities</option>
            <?php
            foreach ($cities as $city) {
                echo '<option value="'.$city['city'].'">'.$city['city'].'</option>';
            }
            ?>
            <!--<option value="Ely">Ely</option>-->
            <!--            <option value="Reno">Reno</option>-->
            <!--            <option value="Sparks">Sparks</option>
                        <option value="Lovelock">Lovelock</option>
                        <option value="Fernley">Fernley</option>
                        <option value="Yerington">Yerington</option>
                        <option value="Caliente">Caliente</option>
                        <option value="Winnemucca">Winnemucca</option>
                        <option value="Carlin">Carlin</option>
                        <option value="Elko">Elko</option>
                        <option value="Wells">Wells</option>
                        <option value="West Wendover">West Wendover</option>
                        <option value="Boulder City">Boulder City</option>
                        <option value="Henderson">Henderson</option>
                        <option value="Las Vegas">Las Vegas</option>
                        <option value="Mesquite">Mesquite</option>
                        <option value="North Las Vegas">North Las Vegas</option>
                        <option value="Fallon">Fallon</option>
                        <option value="Carson City">Carson City</option>-->
        </select>
    </div>
</div>
