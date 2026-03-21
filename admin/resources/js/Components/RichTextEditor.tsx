import React, { useCallback } from 'react';
import { useEditor, EditorContent } from '@tiptap/react';
import StarterKit from '@tiptap/starter-kit';
import Link from '@tiptap/extension-link';
import Image from '@tiptap/extension-image';
import { 
  Bold, 
  Italic, 
  List, 
  ListOrdered, 
  Quote, 
  Undo, 
  Redo, 
  Heading1, 
  Heading2, 
  Heading3, 
  Heading4,
  Heading5,
  Link as LinkIcon,
  ImageIcon,
  Type
} from 'lucide-react';
import { cn } from '@/lib/utils';
import axios from 'axios';
import { toast } from 'sonner';

interface RichTextEditorProps {
  value: string;
  onChange: (value: string) => void;
  className?: string;
}

const MenuBar = ({ editor }: { editor: any }) => {
  if (!editor) {
    return null;
  }

  const addImage = useCallback(() => {
    const input = document.createElement('input');
    input.type = 'file';
    input.accept = 'image/jpeg,image/png,image/jpg,image/webp,image/avif';
    input.onchange = async (e) => {
      const file = (e.target as HTMLInputElement).files?.[0];
      if (file) {
        // Upload image to server
        const formData = new FormData();
        formData.append('upload', file);
        try {
          const response = await axios.post('/admin/baiviet/upload', formData, {
            headers: {
              'Content-Type': 'multipart/form-data',
            },
          });
          if (response.data && response.data.url) {
            editor.chain().focus().setImage({ src: response.data.url }).run();
          } else {
             toast.error('Tải ảnh lên thất bại');
          }
        } catch (error) {
           toast.error('Lỗi tải ảnh lên');
        }
      }
    };
    input.click();
  }, [editor]);

  const setLink = useCallback(() => {
    const previousUrl = editor.getAttributes('link').href;
    const url = window.prompt('URL:', previousUrl);

    // cancelled
    if (url === null) {
      return;
    }

    // empty
    if (url === '') {
      editor.chain().focus().extendMarkRange('link').unsetLink().run();
      return;
    }

    // update link
    editor.chain().focus().extendMarkRange('link').setLink({ href: url }).run();
  }, [editor]);


  const buttons = [
    {
      icon: <Type size={16} />,
      onClick: () => editor.chain().focus().setParagraph().run(),
      isActive: editor.isActive('paragraph'),
      title: 'Đoạn văn'
    },
    {
      icon: <Heading1 size={16} />,
      onClick: () => editor.chain().focus().toggleHeading({ level: 1 }).run(),
      isActive: editor.isActive('heading', { level: 1 }),
      title: 'Heading 1'
    },
    {
      icon: <Heading2 size={16} />,
      onClick: () => editor.chain().focus().toggleHeading({ level: 2 }).run(),
      isActive: editor.isActive('heading', { level: 2 }),
      title: 'Heading 2'
    },
    {
      icon: <Heading3 size={16} />,
      onClick: () => editor.chain().focus().toggleHeading({ level: 3 }).run(),
      isActive: editor.isActive('heading', { level: 3 }),
      title: 'Heading 3'
    },
    {
      icon: <Bold size={16} />,
      onClick: () => editor.chain().focus().toggleBold().run(),
      isActive: editor.isActive('bold'),
      title: 'In đậm'
    },
    {
      icon: <Italic size={16} />,
      onClick: () => editor.chain().focus().toggleItalic().run(),
      isActive: editor.isActive('italic'),
      title: 'In nghiêng'
    },
    {
      icon: <List size={16} />,
      onClick: () => editor.chain().focus().toggleBulletList().run(),
      isActive: editor.isActive('bulletList'),
      title: 'Danh sách không thứ tự'
    },
    {
      icon: <ListOrdered size={16} />,
      onClick: () => editor.chain().focus().toggleOrderedList().run(),
      isActive: editor.isActive('orderedList'),
      title: 'Danh sách có thứ tự'
    },
    {
      icon: <Quote size={16} />,
      onClick: () => editor.chain().focus().toggleBlockquote().run(),
      isActive: editor.isActive('blockquote'),
      title: 'Trích dẫn'
    },
    {
      icon: <LinkIcon size={16} />,
      onClick: setLink,
      isActive: editor.isActive('link'),
      title: 'Chèn link'
    },
    {
      icon: <ImageIcon size={16} />,
      onClick: addImage,
      isActive: false,
      title: 'Chèn ảnh'
    },
    {
      icon: <Undo size={16} />,
      onClick: () => editor.chain().focus().undo().run(),
      isActive: false,
      title: 'Hoàn tác'
    },
    {
      icon: <Redo size={16} />,
      onClick: () => editor.chain().focus().redo().run(),
      isActive: false,
      title: 'Làm lại'
    },
  ];

  return (
    <div className="flex flex-wrap gap-1 p-2 bg-slate-50 border-b border-slate-200 rounded-t-3xl">
      {buttons.map((btn, index) => (
        <button
          key={index}
          onClick={(e) => { e.preventDefault(); btn.onClick(); }}
          className={cn(
            "p-2 rounded-xl transition-all",
            btn.isActive 
              ? "bg-slate-200 text-slate-900 shadow-sm" 
              : "text-slate-500 hover:bg-slate-200/50 hover:text-slate-700"
          )}
          title={btn.title}
          type="button"
        >
          {btn.icon}
        </button>
      ))}
    </div>
  );
};

const EXTENSIONS = [
  StarterKit.configure({
    // starter-kit defaults are fine
  }),
  Link.configure({
    openOnClick: false,
    HTMLAttributes: {
      class: 'text-primary underline cursor-pointer',
    },
  }),
  Image.configure({
    inline: true,
    HTMLAttributes: {
      class: 'max-w-full h-auto rounded-xl my-4',
    },
  }),
];

export default function RichTextEditor({ value, onChange, className }: RichTextEditorProps) {
  const handleChange = (content: string) => {
    onChange(content);
  };

  const editor = useEditor({
    extensions: EXTENSIONS,
    content: value,
    onUpdate: ({ editor }) => {
      handleChange(editor.getHTML());
    },
    editorProps: {
      attributes: {
        class: 'prose prose-sm sm:prose-base focus:outline-none min-h-[400px] max-w-none p-6 text-slate-700 [&_h1]:text-3xl [&_h2]:text-2xl [&_h3]:text-xl [&_h1]:font-bold [&_h2]:font-bold [&_h3]:font-bold [&_h1]:mt-8 [&_h1]:mb-4 [&_h2]:mt-6 [&_h2]:mb-3 [&_h3]:mt-4 [&_h3]:mb-2 [&_p]:mb-4 [&_ul]:list-disc [&_ul]:pl-5 [&_ul]:mb-4 [&_ol]:list-decimal [&_ol]:pl-5 [&_ol]:mb-4 [&_blockquote]:border-l-4 [&_blockquote]:border-slate-300 [&_blockquote]:pl-4 [&_blockquote]:italic [&_blockquote]:my-4',
      },
    },
  });

  // Effect to update editor content if value changes from outside (e.g., initial load in Edit)
  React.useEffect(() => {
    if (editor && value !== editor.getHTML()) {
      editor.commands.setContent(value);
    }
  }, [value, editor]);

  return (
    <div className={cn("border border-slate-200 rounded-3xl overflow-hidden bg-white focus-within:ring-2 focus-within:ring-primary/20 transition-all", className)}>
      <MenuBar editor={editor} />
      <div className="bg-slate-50 max-h-[600px] overflow-y-auto w-full">
         <EditorContent editor={editor} className="w-full h-full" />
      </div>
    </div>
  );
}
