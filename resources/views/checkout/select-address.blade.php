
<div class="loading load-address" hidden><div></div><div></div><div></div><div></div></div>
<div class="form-payment col-12">
    <label for="">Select From Address List</label>
    <select name="addressSelect" id="addressSelect" class="form-select" required>
        <option value="" selected disabled>Select Address</option>
        @forelse ($address as $ad)
        <option {{ old('addressSelect') == $ad->id ? 'selected' : '' }} value="{{$ad->id}}">{{$ad->ship_address.', '.$ad->city.', '.$ad->province.' '.$ad->ship_zip}}</option>
        @empty
        <option value="" selected disabled>Address Unavailable, Please Add New</option>
        @endforelse
    </select>
</div>