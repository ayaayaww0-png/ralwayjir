@extends('layouts.app')

@section('title', 'Daftar Supplier')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div>
            <h1 style="color: #0f2b4a; font-size: 22px; margin-bottom: 4px;">🏪 Daftar Supplier</h1>
            <p style="color: #6b7a8f; font-size: 14px;">Kelola supplier barang.</p>
        </div>
        @if(Auth::user()->role == 'admin')
            <a href="{{ route('supplier.create') }}" style="background: #0f2b4a; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; transition: background 0.3s;">
                + Tambah Supplier
            </a>
        @endif
    </div>

    @if(session('success'))
        <div style="background: #dcfce7; border-left: 4px solid #22c55e; padding: 12px 16px; border-radius: 8px; margin-bottom: 18px; color: #166534;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background: #fee2e2; border-left: 4px solid #dc2626; padding: 12px 16px; border-radius: 8px; margin-bottom: 18px; color: #991b1b;">
            {{ session('error') }}
        </div>
    @endif

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
            <thead>
                <tr style="background: #f1f4f9;">
                    <th style="padding: 12px 15px; text-align: left; border-bottom: 2px solid #dce3ed;">ID</th>
                    <th style="padding: 12px 15px; text-align: left; border-bottom: 2px solid #dce3ed;">Nama Supplier</th>
                    <th style="padding: 12px 15px; text-align: left; border-bottom: 2px solid #dce3ed;">Dibuat</th>
                    <th style="padding: 12px 15px; text-align: center; border-bottom: 2px solid #dce3ed;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($suppliers as $supplier)
                    <tr style="border-bottom: 1px solid #e2e8f0;">
                        <td style="padding: 10px 15px;">{{ $supplier->id_supplier }}</td>
                        <td style="padding: 10px 15px; font-weight: 500;">{{ $supplier->nama_supplier }}</td>
                        <td style="padding: 10px 15px;">{{ $supplier->created_at->format('d-m-Y H:i') }}</td>
                        <td style="padding: 10px 15px; text-align: center;">
                            <a href="{{ route('supplier.show', $supplier->id_supplier) }}" style="color: #1a4a7a; text-decoration: none; margin-right: 8px;">Detail</a>
                            @if(Auth::user()->role == 'admin')
                                <a href="{{ route('supplier.edit', $supplier->id_supplier) }}" style="color: #92400e; text-decoration: none; margin-right: 8px;">Edit</a>
                                <form action="{{ route('supplier.destroy', $supplier->id_supplier) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Yakin hapus supplier ini?')" style="background: none; border: none; color: #991b1b; cursor: pointer; font-size: 14px; text-decoration: underline;">
                                        Hapus
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="padding: 40px; text-align: center; color: #6b7a8f;">
                            📭 Belum ada supplier.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection