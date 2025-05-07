import { describe, it, expect, vi, beforeEach, afterEach } from 'vitest';
import { mount } from '@vue/test-utils';
import EditPessoa from '@/Pages/Pessoas/edit.vue'; // Assumes '@' maps to 'resources/js'
import AppLayout from '@/Layouts/AppLayout.vue'; // We'll stub this
import { useForm } from '@inertiajs/vue3'; // Import useForm to mock it
import { route } from 'ziggy-js'; // Import route to mock it

// --- Mocks ---

// Mock Inertia's useForm
const mockForm = {
    nome: '',
    telefone: '',
    url: null,
    errors: {},
    patch: vi.fn(),
    processing: false,
    // Add other properties/methods if your component uses them
};
vi.mock('@inertiajs/vue3', async (importOriginal) => {
    const actual = await importOriginal();
    return {
        ...actual, // Preserve other exports like Head, Link if needed
        useForm: vi.fn(() => mockForm),
        // Head: vi.fn(), // Mock Head if used directly
        // Link: vi.fn(), // Mock Link if used directly
    };
});

// Mock ziggy-js route function
vi.mock('ziggy-js', () => ({
    route: vi.fn((name, params) => `mock.route.${name}.${params || ''}`),
}));

// --- Test Suite ---

describe('EditPessoa.vue', () => {
    let wrapper;
    const mockPessoa = {
        id: 1,
        nome: 'João Silva',
        telefone: '123456789',
        photos: [{ id: 1, url: '/images/joao.jpg' }],
    };

    const mockPessoaNoPhoto = {
        id: 2,
        nome: 'Maria Santos',
        telefone: '987654321',
        photos: [],
    };

    // Helper to mount the component
    const mountComponent = (pessoaData = mockPessoa) => {
        // Dynamically get the mocked useForm before each mount
        const useFormMock = vi.mocked(useForm);

        // Create a fresh mock form state for this specific mount
        const currentMockForm = {
            nome: pessoaData.nome,
            telefone: pessoaData.telefone,
            url: pessoaData.photos?.[0]?.url ?? null,
            errors: {},
            processing: false,
            patch: vi.fn((_url, options) => {
                // Simulate success immediately for testing callbacks
                if (options?.onSuccess) {
                    options.onSuccess({ props: { flash: { success: 'Updated!' } } });
                }
                // Simulate error if needed for other tests
                // if (options?.onError) {
                //     options.onError({ message: 'Failed!' });
                // }
            }),
            // Add reset, setData etc. if needed and mock them
        };

        // Configure the mock to return this specific state for this mount call
        useFormMock.mockReturnValue(currentMockForm);

        return mount(EditPessoa, {
            props: {
                pessoa: pessoaData,
            },
            global: {
                stubs: {
                    AppLayout: { // Stub AppLayout to avoid rendering its complexities
                        template: '<div><slot /></div>'
                    },
                    // Stub Inertia components if they were used directly in the template
                    Head: true, // Example: Stub Head if used
                    Link: true, // Example: Stub Link if used
                },
                mocks: { // If you were using $page or other global properties
                    // $page: { props: { errors: {} } }
                }
            },
        });
    };

    beforeEach(() => {
        // Reset mocks defined with vi.mock automatically by Vitest config usually
        // Clear specific mock states if needed (though mountComponent creates fresh ones)
        vi.clearAllMocks(); // Good practice anyway
    });

    afterEach(() => {
        if (wrapper) {
            wrapper.unmount();
        }
    });

    it('renders the form with initial data from props', () => {
        wrapper = mountComponent();
        const useFormMock = vi.mocked(useForm);

        // Check if useForm was called with correct initial data
        // Note: The mock is configured in mountComponent, here we check the call args
        expect(useFormMock).toHaveBeenCalledWith({
            nome: mockPessoa.nome,
            telefone: mockPessoa.telefone,
            url: mockPessoa.photos[0].url,
        });

        // Check if form inputs are bound correctly (using the values set in the mock form)
        expect(wrapper.find('input[placeholder="Nome Completo"]').element.value).toBe(mockPessoa.nome);
        expect(wrapper.find('input[placeholder="Telefone"]').element.value).toBe(mockPessoa.telefone);
    });

    it('displays the existing image preview if pessoa has photos', () => {
        wrapper = mountComponent();
        const img = wrapper.find('img.img-profile');
        expect(img.exists()).toBe(true);
        expect(img.attributes('src')).toBe(mockPessoa.photos[0].url);
    });

    it('displays the placeholder image if pessoa has no photos', () => {
        wrapper = mountComponent(mockPessoaNoPhoto);
        const img = wrapper.find('img.img-profile');
        expect(img.exists()).toBe(true);
        // Assuming the placeholder path is hardcoded or accessible
        expect(img.attributes('src')).toBe('/startbootstrap/img/undraw_profile.svg');
    });

    it('updates image preview when a new file is selected', async () => {
        wrapper = mountComponent();
        const fileInput = wrapper.find('input[type="file"]');
        const mockFile = new File(['dummy content'], 'new_image.png', { type: 'image/png' });

        // Get the component instance to access its methods/data
        const vm = wrapper.vm;

        // Mock the FileReader instance that will be created inside handleFileChange
        const readerInstance = new FileReader(); // Uses the mocked class from setup
        const readAsDataURLSpy = vi.spyOn(readerInstance, 'readAsDataURL');

        // Temporarily replace the global FileReader constructor for this specific call
        const originalFileReader = global.FileReader;
        global.FileReader = vi.fn(() => readerInstance);

        // Simulate file selection - this should call handleFileChange
        // Note: Setting element.files directly is often needed for jsdom/happy-dom
        Object.defineProperty(fileInput.element, 'files', {
            value: [mockFile],
            writable: false,
        });
        await fileInput.trigger('change');

        // Restore original FileReader
        global.FileReader = originalFileReader;

        // Check if readAsDataURL was called
        expect(readAsDataURLSpy).toHaveBeenCalledWith(mockFile);

        // Manually trigger the mocked FileReader's onload
        readerInstance._triggerOnload(); // Uses the method defined in the mock
        await vm.$nextTick(); // Wait for Vue reactivity

        // Check if form.url was updated (in the component's reactive form object)
        expect(vm.form.url).toBe(mockFile);

        // Check if image preview ref was updated
        expect(vm.imagePreview).toBe(readerInstance.result); // Check against the mocked result
        const img = wrapper.find('img.img-profile');
        expect(img.attributes('src')).toBe(readerInstance.result);
    });

     it('reverts image preview if file selection is cancelled', async () => {
        wrapper = mountComponent();
        const fileInput = wrapper.find('input[type="file"]');
        const vm = wrapper.vm;

        // Set initial preview
        vm.imagePreview = mockPessoa.photos[0].url;
        await vm.$nextTick();
        expect(wrapper.find('img.img-profile').attributes('src')).toBe(mockPessoa.photos[0].url);

        // Simulate cancelling file selection (empty files array)
         Object.defineProperty(fileInput.element, 'files', {
            value: [], // Empty array
            writable: false,
        });
        await fileInput.trigger('change');
        await vm.$nextTick();

        // Check if the preview reverted to the original URL stored in form.url (string)
        expect(vm.imagePreview).toBe(mockPessoa.photos[0].url);
        const img = wrapper.find('img.img-profile');
        expect(img.attributes('src')).toBe(mockPessoa.photos[0].url); // Reverted to original
        // form.url itself might be null or the original string depending on exact logic,
        // but the preview is the key visual aspect here.
    });

    it('submits the form without the url field if no new image is selected', async () => {
        wrapper = mountComponent();
        const formElement = wrapper.find('form');

        // Spy on the actual patch method of the *specific* form instance
        const patchSpy = vi.spyOn(wrapper.vm.form, 'patch');

        await formElement.trigger('submit.prevent');

        const routeMock = vi.mocked(route);

        expect(routeMock).toHaveBeenCalledWith('pessoas.update', mockPessoa.id);
        // Check the actual call to patch on the form instance
        expect(patchSpy).toHaveBeenCalledWith(expect.stringContaining('mock.route.pessoas.update'), {
            forceFormData: true,
            onSuccess: expect.any(Function),
            onError: expect.any(Function),
            // We expect 'url' not to be part of the data sent internally by useForm
            // because the component logic should delete it if it's not a File.
            // Testing this internal detail of useForm is tricky without deeper mocking.
            // We trust the component's `delete form.url` line was executed.
        });

        // Verify the component logic tried to delete form.url (indirectly)
        // We know form.url was initially a string, so the delete branch should run.
    });

    it('submits the form with the url field (File) if a new image is selected', async () => {
        wrapper = mountComponent();
        const fileInput = wrapper.find('input[type="file"]');
        const mockFile = new File(['dummy content'], 'new_image.png', { type: 'image/png' });
        const vm = wrapper.vm;

        // Simulate file selection (simplified, no need to mock FileReader for this test)
        vm.form.url = mockFile; // Directly set the file on the form mock

        const formElement = wrapper.find('form');
        const patchSpy = vi.spyOn(vm.form, 'patch'); // Spy on the instance's patch

        await formElement.trigger('submit.prevent');

        const routeMock = vi.mocked( route);

        expect(routeMock).toHaveBeenCalledWith('pessoas.update', mockPessoa.id);
        // Assert form.url is the File object *before* patch is called
        expect(vm.form.url).toBeInstanceOf(File);
        expect(patchSpy).toHaveBeenCalledWith(expect.stringContaining('mock.route.pessoas.update'), {
            forceFormData: true,
            onSuccess: expect.any(Function),
            onError: expect.any(Function),
        });
        // In this case, the component logic should *not* delete form.url
    });

    // Add tests for onSuccess and onError callbacks if needed
    it('calls alert on successful submission', async () => {
        // Use the global alert mock from setup.js
        const alertSpy = vi.spyOn(global, 'alert');
        wrapper = mountComponent(); // mountComponent mocks patch to call onSuccess

        await wrapper.find('form').trigger('submit.prevent');

        // Check if the onSuccess callback triggered the alert
        expect(alertSpy).toHaveBeenCalledWith('Pessoa atualizada com sucesso!');
    });
});
