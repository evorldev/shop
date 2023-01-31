<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        @vite(['resources/css/app.css', 'resources/sass/main.sass', 'resources/js/app.js'])
    </head>
    <body class="antialiased">

        <h2 class="pt-8">Product (Brand) - Category</h2>
        <ul class="pl-8">
            @foreach ($products as $product)
                <li>
                    [{{ $product->id }}] {{ $product->title }} ([{{ $product->brand->id }}] {{ $product->brand->title }})

                    <ul class="pl-8">
                    @foreach ($product->categories as $category)
                        <li>
                            [{{ $category->id }}] {{ $category->title }}
                        </li>
                    @endforeach
                    </ul>
                </li>
            @endforeach
        </ul>

        <h2 class="pt-8">Category - Product - Brand</h2>
        <ul class="pl-8">
            @foreach ($categories as $category)
                <li>
                    [{{ $category->id }}] {{ $category->title }}

                    <ul class="pl-8">
                    @foreach ($category->products as $product)
                        <li>
                            [{{ $product->id }}] {{ $product->title }}

                            <ul class="pl-8">
                                <li>
                                    [{{ $product->brand->id }}] {{ $product->brand->title }}
                                </li>
                            </ul>
                        </li>
                    @endforeach
                    </ul>
                </li>
            @endforeach
        </ul>

        <h2 class="pt-8">Brand - Product - Category</h2>
        <ul class="pl-8">
            @foreach ($brands as $brand)
                <li>
                    [{{ $brand->id }}] {{ $brand->title }}

                    <ul class="pl-8">
                    @foreach ($brand->products as $product)
                        <li>
                            [{{ $product->id }}] {{ $product->title }}

                            <ul class="pl-8">
                            @foreach ($product->categories as $category)
                                <li>
                                    [{{ $category->id }}] {{ $category->title }}
                                </li>
                            @endforeach
                            </ul>
                        </li>
                    @endforeach
                    </ul>
                </li>
            @endforeach
        </ul>

    </body>
</html>
