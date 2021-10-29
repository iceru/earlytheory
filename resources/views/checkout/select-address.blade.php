
<div class="loading load-address" hidden><div></div><div></div><div></div><div></div></div>
<div class="form-payment col-12">
    <label for="">Pilih dari Daftar Alamat</label>
    <select name="addressSelect" id="addressSelect" class="form-select" required>
        <option value="" selected disabled>Pilih Alamat</option>
        @forelse ($address as $ad)
        <option {{ old('addressSelect') == $ad->id ? 'selected' : '' }} value="{{$ad->id}}">{{$ad->ship_address.', '.$ad->city.', '.$ad->province.' '.$ad->ship_zip}}</option>
        @empty
        <option value="" selected disabled>Alamat tidak tersedia, Mohon tambahkan alamat</option>
        @endforelse
    </select>
</div>