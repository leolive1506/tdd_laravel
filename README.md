# TDD
```sh
# ./vendor/bin/phpunit --filter=test_example
php artisan test --filter=test_example
```

- Arrange (Prepara / faz arranjo para pode agir)
- Act
- Assert
```php
/** @test */
public function it_should_be_able_to_invite_someone_to_the_platform()
{
    // arrange
        Mail::fake();
        // preciso um usuário vá convidar

        /** @var User $user */
        $user = User::factory()->create();

        // preciso estar logado
        $this->actingAs($user);
    // act
    $this->post('invite', ['email' => 'novo@gmail.com']);

    // assert
        // email foi criado
        Mail::assertSent(Invitation::class, function ($mail) {
            return $mail->hasTo('novo@gmail.com');
        });
        // criou convite no banco de dados
        $this->assertDatabaseHas('invites', ['email' => 'novo@gmail.com']);

}
```

# Trais
- DatabaseTransactions;
    - supoe que banco de dados esteja completo
    - trata como transaction e da rollback em tudo antes finalizar
- RefreshDatabase;
    - a cada test que rodar, mata banco de dados e sube de novo
# Dicas
- mostrar exception qeu ira estourar 
    - $this->withoutExceptionHandling()
## Extensões VSCode
- better PHPUnit
- PHPUNit test explorer
- Test explorer UI

## [brasil apis](https://brasilapi.com.br/docs)
- disponibiliza cnpf, cep
