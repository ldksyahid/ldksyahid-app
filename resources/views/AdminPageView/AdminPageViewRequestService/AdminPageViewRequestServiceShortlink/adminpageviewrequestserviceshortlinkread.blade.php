<table class="table table-bordered">
    <thead>
        <tr align='center'>
            <th scope="col">No</th>
            <th scope="col">Full Name</th>
            <th scope="col">Whatsapp</th>
            <th scope="col">Note</th>
            <th scope="col">Fix Custom Link</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse($data as $key => $item)
        <tr class="small">
            <td scope="row" align='center'>{{$key + 1}}</td>
            <td align='center'>{{$item->name}}</td>
            <td align='center'>{{$item->whatsapp}}</td>
            <td align='justify'>{{$item->note}}</td>
            <td align='center'>
                @if ($item->fixCustomLink == null)
                    <p class="small">Nothing</p>
                @else
                    <a href="{{ $item->fixCustomLink }}" target="_blank">{{ $item->fixCustomLink }}</a>
                @endif
            </td>
            <td align="center">
                <button class="btn btn-sm btn-primary m-1" onClick="addFixCustomLink({{ $item->id }})"><i class="fa fa-edit"></i></button>
                <button class="btn btn-sm btn-primary m-1" onClick="destroyReqShortlink({{ $item->id }})"><i class="fa fa-trash"></i></button>
                <button class="btn btn-sm btn-primary m-1" onClick="previewReqShortlink({{ $item->id }})"><i class="fa fa-eye"></i></button>
                <a href="https://api.whatsapp.com/send?phone={{ $item->whatsapp }}&text=*%5BKUSTOM%20URL%20KAMU%20SUDAH%20JADI%5D*%0A%0A_Assalammu%27alaikum_%0A%0AHalo%20{{ $item->name }}%20%F0%9F%98%80%2C%20Perkenalkan%20Saya%20_{{ Auth::User()->name }}_%2C%20Berikut%20hasil%20link%20yang%20telah%20kami%20Kustom%20menggunakan%20layanan%20kami%20%3A%0A%0A{{ $item->fixCustomLink }}%0A%0A**Link%20Tersebut%20Wajib%20digunakan%20dengan%20Sebagaimana%20Mestinya*%0A%0ATerimakasih%20{{ $item->name }}%20karena%20telah%20menggunakan%20layanan%20kami%20%F0%9F%98%89%0A%0A_Wassalammua%27laikum_%0A%0A%23KitaAdalahSaudara%0A%23LDKSyahid%0A%23PijarAskara%0A%23UINJakarta" target="_blank" class="btn btn-sm btn-primary m-1"><i class="fa fa-send"></i></a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan='9', align='center'>No Request Shortlink Data</td>
        </tr>
        @endforelse
    </tbody>
</table>
