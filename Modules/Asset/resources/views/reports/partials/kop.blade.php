@php
    $kop = \Modules\Asset\Models\InstitutionKop::first();
@endphp

<table style="width: 100%; border-collapse: collapse; border-bottom: 3px double #000; padding-bottom: 6px; margin-bottom: 15px; font-family: {{ $kop->font_family ?? 'Arial, sans-serif' }};">
    <tr>
        <!-- Kolom Logo di Kiri (Mengambil langsung dari folder public/images) -->
        <td style="width: 15%; text-align: center; vertical-align: middle; padding-left: 10px;">
          
            <img src="{{ asset('storage/' . $kop->logo) }}" alt="Logo" style="width: 70px; height: auto; display: inline-block;">
            
        </td>

        <!-- Kolom Teks 5 Baris di Tengah -->
        <td style="width: 85%; text-align: center; vertical-align: middle; padding-right: 15%;">
            <div style="font-size: {{ $kop->size_1 ?? '13px' }}; font-weight: bold; text-transform: uppercase; line-height: 1.2;">
                {{ $kop->line_1 ?? '' }}
            </div>
            <div style="font-size: {{ $kop->size_2 ?? '15px' }}; font-weight: bold; text-transform: uppercase; line-height: 1.2;">
                {{ $kop->line_2 ?? '' }}
            </div>
            <div style="font-size: {{ $kop->size_3 ?? '12px' }}; font-weight: bold; text-transform: uppercase; line-height: 1.2;">
                {{ $kop->line_3 ?? '' }}
            </div>
            <div style="font-size: {{ $kop->size_4 ?? '10px' }}; line-height: 1.1; margin-top: 2px;">
                {{ $kop->line_4 ?? '' }}
            </div>
            <div style="font-size: {{ $kop->size_5 ?? '10px' }}; line-height: 1.1;">
                {{ $kop->line_5 ?? '' }}
            </div>
        </td>
    </tr>
</table>