<?php

use Illuminate\Database\Seeder;
class EmailTemplatetableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $data = [
            'name'          => 'Forget Password',
            'slug'          => 'forget-password',
            'subject'       => 'Password Recovery',
            'content'       => '<p>Hey [name],</p><p>Are you forget your password,</p><p>Here is your link of reset your password:</p><p>[link]</p><p>Thank you for using our system.</p><p>&nbsp;</p><p>Andit Team</p><p>Khulna, Bangladesh</p>',
            'description'   => 'Recovery password',
            'from_name'     => 'Shariful Islam',
            'from_email'    => 'shariful.info55@gmail.com',
            'cc_email'      => '',
            'created_at'    => now(),
        ];
        \DB::table('email_templates')->insert($data);
    }
}
