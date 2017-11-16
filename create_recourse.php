  <?php

  Schema::create('recourses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('surname')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('user_note')->nullable();
            $table->string('password')->nullable();
            $table->unsignedSmallInteger('vehicle_model')->nullable();
            $table->unsignedInteger('vehicle_km')->nullable();
            $table->string('vehicle_note')->nullable();
            $table->string('plate')->nullable();
            $table->string('company_name')->nullable();
            $table->string('tax_no')->nullable();
            $table->longText('company_address')->nullable();
            $table->text('license_files')->nullable();
            $table->text('company_files')->nullable();
            $table->text('personal_files')->nullable();
            $table->text('vehicle_files')->nullable();
            $table->timestamps();
        });

        ?>
