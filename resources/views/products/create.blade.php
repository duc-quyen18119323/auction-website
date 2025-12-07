<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Sản Phẩm Đấu Giá</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }
        .input-field {
            transition: all 0.3s ease;
        }
        .input-field:focus {
            transform: scale(1.01);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        .file-upload-area {
            transition: all 0.3s ease;
        }
        .file-upload-area:hover {
            border-color: #3b82f6;
            background-color: #eff6ff;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
    @include('components.navbar')

    <div class="max-w-4xl mx-auto px-4 py-12">
        <div class="bg-white rounded-xl shadow-2xl p-8 md:p-12 fade-in-up">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full mb-4">
                    <i class="fas fa-plus text-white text-2xl"></i>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Đăng Sản Phẩm Đấu Giá</h2>
                <p class="text-gray-600">Điền thông tin sản phẩm của bạn để bắt đầu đấu giá</p>
            </div>
            @if(isset($errors) && is_object($errors) && $errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg shadow-md">
                    <div class="flex items-center gap-2 mb-2">
                        <i class="fas fa-exclamation-circle text-xl"></i>
                        <p class="font-semibold">Có lỗi xảy ra:</p>
                    </div>
                    <ul class="list-disc list-inside ml-6">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Product Name -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                        <i class="fas fa-tag mr-2 text-blue-600"></i>Tên sản phẩm <span class="text-red-500">*</span>
                    </label>
                    <input class="input-field w-full py-3 px-4 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-gray-700"
                           id="name"
                           type="text"
                           name="name"
                           value="{{ old('name') }}"
                           placeholder="Nhập tên sản phẩm..."
                           required>
                </div>

                <!-- Images Upload -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        <i class="fas fa-images mr-2 text-blue-600"></i>Ảnh sản phẩm (tối đa 6 ảnh) <span class="text-red-500">*</span>
                    </label>
                    <div class="file-upload-area border-2 border-dashed border-gray-300 rounded-lg p-6 text-center cursor-pointer hover:border-blue-400 transition-all duration-200">
                        <input type="file"
                               name="images[]"
                               class="hidden"
                               id="image-upload"
                               multiple
                               accept="image/*"
                               onchange="updateImagePreview(this)">
                        <label for="image-upload" class="cursor-pointer">
                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                            <p class="text-gray-600 font-medium">Click để chọn ảnh hoặc kéo thả vào đây</p>
                            <p class="text-sm text-gray-400 mt-1">PNG, JPG, GIF tối đa 2MB</p>
                        </label>
                        <div id="image-preview" class="mt-4 grid grid-cols-3 gap-4 hidden"></div>

                    </div>
                </div>

                <!-- Video Upload -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        <i class="fas fa-video mr-2 text-blue-600"></i>Video sản phẩm (tùy chọn)
                    </label>
                    <input type="file"
                           name="video"
                           class="w-full py-3 px-4 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                           accept="video/*">
                </div>

                <!-- Category -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="category">
                        <i class="fas fa-folder mr-2 text-blue-600"></i>Loại sản phẩm <span class="text-red-500">*</span>
                    </label>
                    <select class="input-field w-full py-3 px-4 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-gray-700 bg-white"
                            id="category"
                            name="category"
                            required>
                        <option value="">-- Chọn loại sản phẩm --</option>
                        <option value="do-thu-cong" {{ old('category') == 'do-thu-cong' ? 'selected' : '' }}>Đồ thủ công</option>
                        <option value="do-cong-nghe" {{ old('category') == 'do-cong-nghe' ? 'selected' : '' }}>Đồ công nghệ</option>
                        <option value="do-gia-dung" {{ old('category') == 'do-gia-dung' ? 'selected' : '' }}>Đồ gia dụng</option>
                    </select>
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                        <i class="fas fa-align-left mr-2 text-blue-600"></i>Mô tả <span class="text-red-500">*</span>
                    </label>
                    <textarea class="input-field w-full py-3 px-4 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-gray-700 resize-none"
                              id="description"
                              name="description"
                              rows="4"
                              placeholder="Mô tả chi tiết về sản phẩm..."
                              required>{{ old('description') }}</textarea>
                </div>

                <!-- Price Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="starting_price">
                            <i class="fas fa-dollar-sign mr-2 text-green-600"></i>Giá khởi điểm (VNĐ) <span class="text-red-500">*</span>
                        </label>
                        <input class="input-field w-full py-3 px-4 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-gray-700"
                               id="starting_price"
                               type="number"
                               step="1000"
                               name="starting_price"
                               value="{{ old('starting_price') }}"
                               placeholder="0"
                               required>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="bid_step">
                            <i class="fas fa-arrow-up mr-2 text-purple-600"></i>Bước giá (VNĐ) <span class="text-red-500">*</span>
                        </label>
                        <input class="input-field w-full py-3 px-4 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-gray-700"
                               id="bid_step"
                               type="number"
                               step="1000"
                               name="bid_step"
                               value="{{ old('bid_step') }}"
                               placeholder="0"
                               required>
                    </div>
                </div>

                <!-- Time Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="start_time">
                            <i class="fas fa-play-circle mr-2 text-blue-600"></i>Thời gian bắt đầu <span class="text-red-500">*</span>
                        </label>
                        <input class="input-field w-full py-3 px-4 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-gray-700"
                               id="start_time"
                               type="datetime-local"
                               name="start_time"
                               value="{{ old('start_time') }}"
                               required>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="end_time">
                            <i class="fas fa-stop-circle mr-2 text-red-600"></i>Thời gian kết thúc <span class="text-red-500">*</span>
                        </label>
                        <input class="input-field w-full py-3 px-4 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-gray-700"
                               id="end_time"
                               type="datetime-local"
                               name="end_time"
                               value="{{ old('end_time') }}"
                               required>
                    </div>
                </div>

                <!-- Warranty -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        <i class="fas fa-shield-alt mr-2 text-yellow-600"></i>Chế độ bảo hành <span class="text-red-500">*</span>
                    </label>
                    <div class="flex items-center gap-8 mt-3">
                        <label class="flex items-center cursor-pointer group">
                            <input type="radio"
                                   name="warranty"
                                   value="co"
                                   class="w-5 h-5 text-blue-600 focus:ring-blue-500"
                                   {{ old('warranty') == 'co' ? 'checked' : '' }}
                                   required>
                            <span class="ml-3 text-gray-700 font-medium group-hover:text-blue-600 transition-colors">
                                <i class="fas fa-check-circle mr-2 text-green-600"></i>Có bảo hành
                            </span>
                        </label>
                        <label class="flex items-center cursor-pointer group">
                            <input type="radio"
                                   name="warranty"
                                   value="khong"
                                   class="w-5 h-5 text-blue-600 focus:ring-blue-500"
                                   {{ old('warranty') == 'khong' ? 'checked' : '' }}>
                            <span class="ml-3 text-gray-700 font-medium group-hover:text-blue-600 transition-colors">
                                <i class="fas fa-times-circle mr-2 text-red-600"></i>Không bảo hành
                            </span>
                        </label>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button class="w-full py-4 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-bold text-lg rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center justify-center gap-2"
                            type="submit">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Đăng Sản Phẩm
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
         function updateImagePreview(input) {
        const preview = document.getElementById('image-preview');
        preview.innerHTML = '';

        if (input.files && input.files.length > 0) {
            // Bỏ ẩn khung preview
            preview.classList.remove('hidden');

            Array.from(input.files).forEach((file, index) => {
                if (index >= 6) return; // Giới hạn 6 ảnh

                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'relative';

                    div.innerHTML = `
                        <img src="${e.target.result}" class="w-full h-24 object-cover rounded-lg border-2 border-gray-200">
                        <span class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs cursor-pointer" onclick="removeImage(this)">×</span>
                        <p class="mt-1 text-xs text-gray-600 truncate" title="${file.name}">${file.name}</p>
                    `;
                    preview.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
        } else {
            // Không có file → ẩn khung preview
            preview.classList.add('hidden');
        }
    }

    function removeImage(element) {
        element.parentElement.remove();
    }
        function removeImage(element) {
            element.parentElement.remove();
        }
    </script>
</body>
</html>
