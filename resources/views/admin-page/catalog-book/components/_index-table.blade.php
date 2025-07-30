@php
    use App\Http\Controllers\LibraryFunctionController as LFC;
    $isSuperadmin = LFC::getRoleName(auth()->user()->getRoleNames()) === 'Superadmin';
@endphp

@forelse ($books as $key => $book)
<tr>
    <td>
        <input type="checkbox" name="ids[]" value="{{ $book->bookID }}" {{ $isSuperadmin ? '' : 'disabled' }}>
    </td>
    <th scope="row">{{ $books->firstItem() + $key }}</th>
    <td class="text-center">{{ \Carbon\Carbon::parse($book->createdDate)->isoFormat('DD MMMM YYYY') }}</td>
    <td class="text-center">{{ $book->isbn }}</td>
    <td class="text-center">{{ $book->titleBook }}</td>
    <td class="text-center">{{ $book->authorName }}</td>
    <td class="text-center">{{ $book->publisherName }}</td>
    <td class="text-center">{{ $book->categoryName }}</td>
    <td class="text-center">{{ $book->language }}</td>
    <td class="text-center">{{ $book->year }}</td>
    <td class="text-center">{{ $book->readCount }}</td>
    <td class="text-center">
        <div class="btn-group" role="group">
            <a href="{{ route('admin.catalog.books.show', $book->bookID) }}"
               class="btn btn-sm btn-custom-primary" title="View">
                <i class="fa fa-eye" style="color: white;"></i>
            </a>
            <a href="{{ route('admin.catalog.books.edit', $book->bookID) }}"
               class="btn btn-sm btn-custom-primary" title="Edit">
                <i class="fa fa-edit" style="color: white;"></i>
            </a>
            <button type="button"
                class="btn btn-sm btn-custom-primary"
                onclick="deleteConfirmationBook({{ $book->bookID }})"
                title="Delete">
                <i class="fa fa-trash"></i>
            </button>
        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="12" class="text-center">No books found in the catalog</td>
</tr>
@endforelse
