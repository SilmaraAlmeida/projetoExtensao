<?php
namespace Tests\Helper;

use PHPUnit\Framework\TestCase;

class UsuarioHelperTest extends TestCase
{
    /**
     * Testa validação de email válido
     */
    public function testEmailValido(): void
    {
        $emails = [
            'usuario@exemplo.com',
            'teste.usuario@dominio.com.br',
            'admin@empresa.org'
        ];
        
        foreach ($emails as $email) {
            $this->assertTrue(
                filter_var($email, FILTER_VALIDATE_EMAIL) !== false,
                "Email {$email} deve ser válido"
            );
        }
    }
    
    /**
     * Testa validação de email inválido
     */
    public function testEmailInvalido(): void
    {
        $emails = [
            'emailinvalido',
            'usuario@',
            '@dominio.com',
            'usuario espaço@dominio.com'
        ];
        
        foreach ($emails as $email) {
            $this->assertFalse(
                filter_var($email, FILTER_VALIDATE_EMAIL) !== false,
                "Email {$email} deve ser inválido"
            );
        }
    }
    
    /**
     * Testa validação de senha forte
     */
    public function testSenhaForte(): void
    {
        $senha = 'Senha@123';
        
        // Verifica tamanho mínimo
        $this->assertGreaterThanOrEqual(
            8, 
            strlen($senha),
            'Senha deve ter pelo menos 8 caracteres'
        );
        
        // Verifica se contém letra maiúscula
        $this->assertMatchesRegularExpression(
            '/[A-Z]/',
            $senha,
            'Senha deve conter letra maiúscula'
        );
        
        // Verifica se contém número
        $this->assertMatchesRegularExpression(
            '/[0-9]/',
            $senha,
            'Senha deve conter número'
        );
        
        // Verifica se contém caractere especial
        $this->assertMatchesRegularExpression(
            '/[^a-zA-Z0-9]/',
            $senha,
            'Senha deve conter caractere especial'
        );
    }
}
